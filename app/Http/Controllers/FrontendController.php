<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use App\Services\Algorithms\ContentSimilarityService;
use App\Services\LearningPacingService;
use App\Services\LessonProgressService;
use App\Services\RecommendationService;
use App\Services\SpacedRepetitionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    protected $collabService;

    protected $similarityService;

    public function __construct(
        RecommendationService $collabService,
        ContentSimilarityService $similarityService
    ) {
        $this->collabService = $collabService;
        $this->similarityService = $similarityService;
    }

    public function landing()
    {
        $courses = Course::where('is_published', true)
            ->withCount('enrollments')
            ->orderByDesc('trending_score')
            ->latest()
            ->limit(6)
            ->get();

        $stats = [
            'total_students' => $this->studentCount(),
            'total_courses' => Course::where('is_published', true)->count(),
            'total_lessons' => Lesson::where('is_published', true)->count(),
        ];

        return view('frontend.landing', [
            'courses' => $courses,
            'stats' => $stats,
        ]);
    }

    public function dashboard()
    {
        $userId = Auth::id();
        $user = Auth::user();

        $courses = Course::where('is_published', true)
            ->latest()
            ->limit(6)
            ->get();
        $recommendations = $userId ? $this->collabService->getRecommendedCourses(Auth::user(), 5) : collect();

        // Learning Pacing predictions for the student's enrolled courses
        $pacingService = app(LearningPacingService::class);
        $enrolledPacing = [];

        if ($user) {
            $enrollments = Enrollment::where('user_id', $userId)
                ->with('course')
                ->get();

            foreach ($enrollments as $enrollment) {
                if ($enrollment->course) {
                    $predictedDate = $pacingService->predictCompletionDate($user, $enrollment->course);
                    $courseLessonIds = $enrollment->course->lessons()->pluck('lessons.id');
                    $totalLessons = $courseLessonIds->count();
                    $completedInCourse = LessonProgress::where('user_id', $userId)
                        ->whereIn('lesson_id', $courseLessonIds)
                        ->whereNotNull('completed_at')
                        ->count();

                    if ($completedInCourse > 0 && $totalLessons > 0) {
                        $progressPercentage = (int) round(($completedInCourse / $totalLessons) * 100);
                    } else {
                        $progressPercentage = (int) ($enrollment->progress_percentage ?? 0);
                    }

                    $effectiveCompleted = $completedInCourse > 0
                        ? $completedInCourse
                        : ($totalLessons > 0 && $progressPercentage > 0 ? (int) round(($progressPercentage / 100) * $totalLessons) : 0);

                    $enrolledPacing[] = [
                        'enrollment' => $enrollment,
                        'course' => $enrollment->course,
                        'predicted_date' => $predictedDate,
                        'total_lessons' => $totalLessons,
                        'completed_lessons' => $effectiveCompleted,
                        'remaining_lessons' => max(0, $totalLessons - $effectiveCompleted),
                        'progress_percentage' => $progressPercentage,
                        'pace_multiplier' => $user->learning_pace_multiplier ?? 1.0,
                    ];
                }
            }
        }

        // Compute overall syllabus progress across enrolled courses
        $totalEnrolledLessons = 0;
        $totalEnrolledCompleted = 0;
        foreach ($enrolledPacing as $p) {
            $totalEnrolledLessons += $p['total_lessons'];
            $totalEnrolledCompleted += $p['completed_lessons'];
        }
        $overallCompletionRate = $totalEnrolledLessons > 0
            ? (int) round(($totalEnrolledCompleted / $totalEnrolledLessons) * 100)
            : 0;

        // Spaced Repetition (SM-2) reviews due today
        $spacedRepetitionService = app(SpacedRepetitionService::class);
        $dueReviews = $user ? $spacedRepetitionService->getDueReviews($user) : collect();
        $dueCourses = $user ? $spacedRepetitionService->getDueCoursesWithFlashcards($user) : collect();

        // Dynamic Stats
        $stats = [
            'total_students' => $this->studentCount(),
            'total_courses' => Course::count(),
            'my_enrollments' => $userId ? Enrollment::where('user_id', $userId)->count() : 0,
            'pace_multiplier' => $user->learning_pace_multiplier ?? 1.0,
            'overall_completion_rate' => $overallCompletionRate,
            'total_completed_lessons' => $totalEnrolledCompleted,
            'total_enrolled_lessons' => $totalEnrolledLessons,
            'due_reviews_count' => $dueReviews->count(),
            'due_courses_count' => $dueCourses->count(),
        ];

        return view('frontend.dashboard', [
            'courses' => $courses,
            'recommendations' => $recommendations,
            'enrolledPacing' => $enrolledPacing,
            'dueReviews' => $dueReviews,
            'dueCourses' => $dueCourses,
            'stats' => $stats,
        ]);
    }

    public function catalog(Request $request)
    {
        $search = $request->input('search');

        $courses = Course::where('is_published', true)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        if (Auth::guest()) {
            return view('frontend.public-catalog', compact('courses', 'search'));
        }

        return view('frontend.catalog', compact('courses', 'search'));
    }

    public function courseDetails($slug)
    {
        $course = Course::where('slug', $slug)
            ->with(['modules.chapters.lessons'])
            ->firstOrFail();

        $userId = Auth::id();
        $isEnrolled = false;
        $progressPercentage = 0;

        if ($userId) {
            $enrollment = Enrollment::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->first();
            $isEnrolled = (bool) $enrollment;
            if ($enrollment) {
                $progressPercentage = $enrollment->progress_percentage;
            }
        }

        // Algorithm 1: Collaborative Filtering – next courses for this user
        $nextRecommendations = $userId ? $this->collabService->getRecommendedCourses(Auth::user(), 5) : collect();

        // Algorithm 2: Content Similarity – related courses
        $relatedCourses = $this->similarityService->getSimilarCourses($course);

        $courseSyllabusUrl = null;
        if (! empty($course->syllabus_pdf)) {
            if (Str::startsWith($course->syllabus_pdf, ['http://', 'https://'])) {
                $courseSyllabusUrl = $course->syllabus_pdf;
            } elseif (Storage::disk('public')->exists($course->syllabus_pdf)) {
                $courseSyllabusUrl = Storage::url($course->syllabus_pdf);
            } elseif (file_exists(public_path($course->syllabus_pdf))) {
                $courseSyllabusUrl = asset($course->syllabus_pdf);
            } elseif (file_exists(public_path('storage/'.$course->syllabus_pdf))) {
                $courseSyllabusUrl = asset('storage/'.$course->syllabus_pdf);
            } else {
                $courseSyllabusUrl = asset($course->syllabus_pdf);
            }
        }

        if (Auth::guest()) {
            return view('frontend.public-course-details', [
                'course' => $course,
                'relatedCourses' => $relatedCourses,
                'courseSyllabusUrl' => $courseSyllabusUrl,
            ]);
        }

        $unlockedLessonIds = [];
        $earliestIncompleteLesson = null;
        $completedLessonIds = [];

        if ($userId) {
            $lessonProgressService = app(LessonProgressService::class);
            $unlockedLessonIds = $lessonProgressService->getUnlockedLessonIds($userId, $course);
            $earliestIncompleteLesson = $lessonProgressService->getEarliestIncompleteLesson($userId, $course);
            $completedLessonIds = LessonProgress::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->pluck('lesson_id')
                ->toArray();
        }

        return view('frontend.course-details', [
            'course' => $course,
            'relatedCourses' => $relatedCourses,
            'nextRecommendations' => $nextRecommendations,
            'isEnrolled' => $isEnrolled,
            'enrollment' => $enrollment ?? null,
            'progressPercentage' => $progressPercentage,
            'courseSyllabusUrl' => $courseSyllabusUrl,
            'unlockedLessonIds' => $unlockedLessonIds,
            'earliestIncompleteLesson' => $earliestIncompleteLesson,
            'completedLessonIds' => $completedLessonIds,
        ]);

    }

    public function analytics()
    {
        $userId = Auth::id();

        if (! $userId) {
            return redirect()->route('login')->with('info', 'Please sign in to view your learning analytics.');
        }

        $totalEnrollments = Enrollment::where('user_id', $userId)->count();
        $completedLessonsCount = LessonProgress::where('user_id', $userId)->count();

        $enrolledCourseIds = Enrollment::where('user_id', $userId)->pluck('course_id');
        $totalLessonsInEnrolledCourses = Lesson::where(function ($query) use ($enrolledCourseIds) {
            $query->whereHas('module', fn ($q) => $q->whereIn('course_id', $enrolledCourseIds))
                ->orWhereHas('chapter.module', fn ($q) => $q->whereIn('course_id', $enrolledCourseIds));
        })->count();

        $completionRate = $totalLessonsInEnrolledCourses > 0
            ? (int) round(($completedLessonsCount / $totalLessonsInEnrolledCourses) * 100)
            : 0;

        $user = Auth::user();
        $pacingService = app(LearningPacingService::class);
        $enrolledPacing = [];

        if ($user) {
            $enrollments = Enrollment::where('user_id', $userId)
                ->with('course')
                ->get();

            foreach ($enrollments as $enrollment) {
                if ($enrollment->course) {
                    $predictedDate = $pacingService->predictCompletionDate($user, $enrollment->course);
                    $totalLessons = $enrollment->course->lessons()->count();
                    $completedInCourse = LessonProgress::where('user_id', $userId)
                        ->whereIn('lesson_id', $enrollment->course->lessons()->pluck('lessons.id'))
                        ->whereNotNull('completed_at')
                        ->count();

                    $enrolledPacing[] = [
                        'course' => $enrollment->course,
                        'predicted_date' => $predictedDate,
                        'total_lessons' => $totalLessons,
                        'completed_lessons' => $completedInCourse,
                        'remaining_lessons' => max(0, $totalLessons - $completedInCourse),
                    ];
                }
            }
        }

        return view('frontend.analytics', [
            'totalEnrollments' => $totalEnrollments,
            'completedLessonsCount' => $completedLessonsCount,
            'completionRate' => $completionRate,
            'paceMultiplier' => $user->learning_pace_multiplier ?? 1.0,
            'enrolledPacing' => $enrolledPacing,
        ]);
    }

    public function visualizer()
    {
        $courses = Course::with('prerequisites')->get();

        return view('frontend.visualizer', compact('courses'));
    }

    public function courseFlashcards(Request $request, string $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $mode = $request->query('mode', 'due'); // 'due' or 'all'

        $spacedService = app(SpacedRepetitionService::class);
        $flashcards = $spacedService->extractFlashcardsForCourse($course, $user, $mode === 'due');

        // If no cards due, but user requested due mode, fallback to all cards with notice
        $allFlashcards = $spacedService->extractFlashcardsForCourse($course, $user, false);
        $dueCount = $allFlashcards->where('is_due', true)->count();

        if ($flashcards->isEmpty() && $mode === 'due' && $allFlashcards->isNotEmpty()) {
            $flashcards = $allFlashcards;
            $mode = 'all';
        }

        return view('frontend.courses.flashcards', [
            'course' => $course,
            'flashcards' => $flashcards,
            'mode' => $mode,
            'dueCount' => $dueCount,
            'totalCount' => $allFlashcards->count(),
        ]);
    }

    public function dueFlashcards(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $spacedService = app(SpacedRepetitionService::class);
        $dueReviews = $spacedService->getDueReviews($user);

        $flashcards = $dueReviews->map(function ($progress) use ($spacedService) {
            return $spacedService->extractFlashcardFromLesson($progress->lesson, $progress);
        });

        return view('frontend.courses.flashcards', [
            'course' => null,
            'flashcards' => $flashcards,
            'mode' => 'due-all',
            'dueCount' => $flashcards->count(),
            'totalCount' => $flashcards->count(),
        ]);
    }

    public function rateLessonReview(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'quality' => 'required|integer|min:0|max:5',
        ]);

        $quality = (int) $request->input('quality');
        $spacedService = app(SpacedRepetitionService::class);
        $progress = $spacedService->recordReviewResponse($user, $lesson, $quality);

        return response()->json([
            'success' => true,
            'lesson_id' => $lesson->id,
            'quality' => $quality,
            'repetitions' => $progress->repetitions,
            'interval' => $progress->interval,
            'easiness_factor' => number_format($progress->easiness_factor, 2),
            'next_review_date' => $progress->next_review_date ? Carbon::parse($progress->next_review_date)->format('Y-m-d') : null,
            'next_review_human' => $progress->next_review_date ? Carbon::parse($progress->next_review_date)->diffForHumans() : 'Today',
        ]);
    }

    private function studentCount(): int
    {
        return User::whereHas('roles', fn ($query) => $query->where('name', 'user'))->count();
    }
}
