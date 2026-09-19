<?php

namespace App\Filament\Pages;

use App\Models\Course;
use App\Models\CoursePrerequisite;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\User;
use App\Services\Algorithms\CollaborativeFilteringService;
use App\Services\Algorithms\ContentSimilarityService;
use App\Services\CourseDependencyService;
use App\Services\LearningPacingService;
use BackedEnum;
use Carbon\Carbon;
use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Artisan;
use UnitEnum;

class AlgorithmReport extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static ?string $navigationLabel = 'Algorithm Report';

    protected static ?string $title = 'Algorithm Performance Report';

    protected static ?string $slug = 'algorithm-report';

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.algorithm-report';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('updateTrending')
                ->label('Update Trending Scores')
                ->icon(Heroicon::OutlinedArrowPath)
                ->requiresConfirmation()
                ->modalHeading('Update Trending Scores')
                ->modalDescription('This will run the trending course calculation.')
                ->action(function () {
                    Artisan::call('courses:update-trending');

                    $this->dispatch('refresh');

                    Notification::make()
                        ->title('Trending scores updated successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getViewData(): array
    {
        return [
            'dagReport' => $this->getDagReport(),
            'trendingReport' => $this->getTrendingReport(),
            'collaborativeReport' => $this->getCollaborativeFilteringReport(),
            // 'contentSimilarityReport' => $this->getContentSimilarityReport(),
            'spacedRepetitionReport' => $this->getSpacedRepetitionReport(),
            'learningPacingReport' => $this->getLearningPacingReport(),
            'overviewStats' => $this->getOverviewStats(),
        ];
    }

    /**
     * Overview statistics for the header cards.
     */
    private function getOverviewStats(): array
    {
        return [
            'total_courses' => Course::count(),
            'total_users' => User::count(),
            'total_enrollments' => Enrollment::count(),
            'total_prerequisites' => CoursePrerequisite::count(),
            'total_lesson_progress' => LessonProgress::count(),
        ];
    }

    /**
     * DAG Validation & Topological Sort report.
     */
    private function getDagReport(): array
    {
        $service = app(CourseDependencyService::class);

        $isValid = false;
        $learningOrder = [];
        $cycleError = null;

        try {
            $isValid = $service->validatePrerequisites();
        } catch (Exception $e) {
            $cycleError = $e->getMessage();
        }

        if ($isValid) {
            try {
                $learningOrder = $service->getLearningOrder();
            } catch (Exception $e) {
                // Ignore if learning order fails
            }
        }

        // Build the dependency edges for display
        $prerequisites = CoursePrerequisite::with(['course', 'prerequisiteCourse'])->get();
        $edges = $prerequisites->map(function ($prereq) {
            return [
                'from_id' => $prereq->prerequisite_course_id,
                'from_title' => $prereq->prerequisiteCourse?->title ?? 'Unknown',
                'to_id' => $prereq->course_id,
                'to_title' => $prereq->course?->title ?? 'Unknown',
            ];
        });

        // Map IDs to titles for the learning order
        $courseTitles = Course::pluck('title', 'id')->toArray();
        $learningOrderNames = array_map(fn ($id) => [
            'id' => $id,
            'title' => $courseTitles[$id] ?? "Course #{$id}",
        ], $learningOrder);

        return [
            'is_valid' => $isValid,
            'cycle_error' => $cycleError,
            'learning_order' => $learningOrderNames,
            'edges' => $edges,
            'total_nodes' => Course::count(),
            'total_edges' => CoursePrerequisite::count(),
        ];
    }

    /**
     * Trending algorithm report.
     */
    private function getTrendingReport(): array
    {
        $courses = Course::whereNotNull('trending_score')
            ->orderByDesc('trending_score')
            ->limit(10)
            ->get(['id', 'title', 'trending_score', 'created_at']);

        $recentEnrollments = Enrollment::where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        return [
            'top_courses' => $courses,
            'recent_enrollments_30d' => $recentEnrollments,
            'gravity_factor' => 1.8,
            'formula' => 'Score = (RecentEnrollments × 10000) / (AgeInHours + 2)^1.8',
        ];
    }

    /**
     * Collaborative Filtering report.
     */
    private function getCollaborativeFilteringReport(): array
    {
        // Get users with enrollments for the demo
        $usersWithEnrollments = User::whereHas('enrollments')
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->limit(5)
            ->get();

        $service = app(CollaborativeFilteringService::class);
        $recommendations = [];

        foreach ($usersWithEnrollments as $user) {
            $recs = $service->getRecommendations($user->id, 3);
            $recommendations[] = [
                'user' => $user,
                'enrolled_count' => $user->enrollments_count,
                'recommendations' => $recs,
            ];
        }

        // Calculate user overlap statistics
        $totalUsers = User::count();
        $usersWithEnrollmentsCount = User::whereHas('enrollments')->count();

        return [
            'recommendations' => $recommendations,
            'total_users' => $totalUsers,
            'users_with_enrollments' => $usersWithEnrollmentsCount,
            'cold_start_users' => $totalUsers - $usersWithEnrollmentsCount,
            'similarity_metric' => 'Jaccard Similarity: |A ∩ B| / |A ∪ B|',
        ];
    }

    /**
     * Content Similarity report.
     */
    // private function getContentSimilarityReport(): array
    // {
    //     $service = app(ContentSimilarityService::class);
    //     $courses = Course::limit(5)->get();
    //     $similarities = [];

    //     foreach ($courses as $course) {
    //         $similar = $service->getSimilarCourses($course, 3);
    //         $similarities[] = [
    //             'course' => $course,
    //             'similar_courses' => $similar,
    //         ];
    //     }

    //     return [
    //         'similarities' => $similarities,
    //         'method' => 'TF-IDF with Cosine Similarity',
    //         'tokenization' => 'Lowercase, punctuation removed, min 4 chars',
    //     ];
    // }

    /**
     * Spaced Repetition report.
     */
    private function getSpacedRepetitionReport(): array
    {
        $dueReviews = LessonProgress::whereNotNull('next_review_date')
            ->where('next_review_date', '<=', Carbon::now())
            ->count();

        $upcomingReviews = LessonProgress::whereNotNull('next_review_date')
            ->where('next_review_date', '>', Carbon::now())
            ->where('next_review_date', '<=', Carbon::now()->addDays(7))
            ->count();

        $avgEasiness = LessonProgress::whereNotNull('easiness_factor')
            ->avg('easiness_factor');

        $totalTracked = LessonProgress::whereNotNull('next_review_date')->count();

        // Distribution of easiness factors
        $easyCount = LessonProgress::whereNotNull('easiness_factor')
            ->where('easiness_factor', '>=', 2.5)
            ->count();
        $mediumCount = LessonProgress::whereNotNull('easiness_factor')
            ->whereBetween('easiness_factor', [1.8, 2.5])
            ->count();
        $hardCount = LessonProgress::whereNotNull('easiness_factor')
            ->where('easiness_factor', '<', 1.8)
            ->count();

        return [
            'due_today' => $dueReviews,
            'upcoming_7d' => $upcomingReviews,
            'avg_easiness' => $avgEasiness ? round($avgEasiness, 2) : null,
            'total_tracked' => $totalTracked,
            'difficulty_distribution' => [
                'easy' => $easyCount,
                'medium' => $mediumCount,
                'hard' => $hardCount,
            ],
            'algorithm' => 'SuperMemo 2 (SM-2)',
            'formula' => 'EF′ = EF + (0.1 − (5 − q) × (0.08 + (5 − q) × 0.02))',
        ];
    }

    /**
     * Learning Pacing report.
     */
    private function getLearningPacingReport(): array
    {
        $usersWithProgress = User::whereHas('roles', fn ($q) => $q->where('name', 'user'))
            ->whereHas('enrollments')
            ->limit(8)
            ->get();

        $service = app(LearningPacingService::class);
        $predictions = [];

        foreach ($usersWithProgress as $user) {
            $userEnrollments = Enrollment::where('user_id', $user->id)
                ->with('course')
                ->get();

            foreach ($userEnrollments->take(2) as $enrollment) {
                if (! $enrollment->course) {
                    continue;
                }

                try {
                    $predicted = $service->predictCompletionDate($user, $enrollment->course);
                    if ($predicted) {
                        $predictions[] = [
                            'user_name' => $user->name,
                            'course_title' => $enrollment->course->title,
                            'predicted_date' => $predicted->format('M d, Y'),
                            'pace_multiplier' => $user->learning_pace_multiplier ?? 1.0,
                        ];
                    }
                } catch (Exception $e) {
                    // Skip on error
                }
            }
        }

        return [
            'predictions' => $predictions,
            'method' => 'Historical Pace Extrapolation',
            'description' => 'Calculates avg time between lesson completions (capped at 48h gaps), then extrapolates remaining lessons.',
        ];
    }
}
