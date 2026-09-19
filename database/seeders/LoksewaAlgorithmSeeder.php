<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use App\Services\TrendingService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeds comprehensive and realistic training data for all 6 LMS algorithms:
 * 1. DAG / Topological Sort (Prerequisites)
 * 2. Trending with Gravity Decay
 * 3. Collaborative Filtering (Jaccard Overlap Matrix)
 * 4. Content-Based Filtering (TF-IDF & Cosine Similarity)
 * 5. Spaced Repetition (SuperMemo SM-2)
 * 6. Learning Pacing & Completion Rate Extrapolation
 */
class LoksewaAlgorithmSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🧠 Training All 6 LMS Algorithms with Realistic Data...');

        $students = User::whereHas('roles', fn ($q) => $q->where('name', 'user'))->get();
        if ($students->isEmpty()) {
            $this->command->error('   ❌ No students found. Run LoksewaUsersSeeder first.');

            return;
        }

        $courses = Course::all();
        if ($courses->isEmpty()) {
            $this->command->error('   ❌ No courses found. Run LoksewaCoursesSeeder first.');

            return;
        }

        // Group all lessons by course ID (supporting both chapter and direct module lessons)
        $lessonsByCourse = collect();
        foreach ($courses as $course) {
            $lessonsByCourse->put($course->id, $course->lessons()->orderBy('lessons.order')->orderBy('lessons.id')->get());
        }

        // 1. Clear existing enrollments & progress for users
        $studentIds = $students->pluck('id')->toArray();
        LessonProgress::whereIn('user_id', $studentIds)->delete();
        Enrollment::whereIn('user_id', $studentIds)->delete();

        // 2. Seed Enrollments across defined user archetypes for Collaborative Filtering + Trending
        $this->seedEnrollmentMatrix($students, $courses);

        // 3. Seed Lesson Progress with SM-2 Spaced Repetition & Real Completion Timestamps for Pacing
        $this->seedLessonProgressAndPacing($students, $lessonsByCourse);

        // 4. Calculate & Cache Trending Scores via TrendingService
        $this->calculateTrending();

        $this->command->info('   ✅ Algorithm Training Complete!');
    }

    private function seedEnrollmentMatrix($students, $courses): void
    {
        $courseBySlug = $courses->keyBy('slug');
        $now = Carbon::now();

        // Map courses
        $cKharidar = $courseBySlug->get('kharidar-tayari')?->id;
        $cNaSu = $courseBySlug->get('nayab-subba-tayari')?->id;
        $cOfficer = $courseBySlug->get('section-officer-tayari')?->id;
        $cNrbOfficer = $courseBySlug->get('nrb-officer-tayari')?->id;
        $cNrbAd = $courseBySlug->get('nrb-assistant-director-tayari')?->id;
        $cConstitution = $courseBySlug->get('nepal-constitution-ra-kanun')?->id;
        $cComputer = $courseBySlug->get('computer-sip-pariksha')?->id;
        $cIq = $courseBySlug->get('baudhik-parikshan-iq-aptitude')?->id;

        // Archetypes:
        // Group 1: General Civil Service Track (Users 0-9) -> Kharidar, NaSu, Constitution, IQ
        // Group 2: Advanced Civil Service Aspirants (Users 10-17) -> NaSu, Section Officer, Constitution, Computer
        // Group 3: Central Banking Track (Users 18-24) -> NRB Officer, NRB AD, Constitution, IQ
        // Group 4: Multi-discipline High Achievers (Users 25-29) -> Kharidar, Section Officer, NRB Officer, IQ, Computer

        $enrollmentPlan = [];

        // Group 1 (Users 0-7)
        foreach (range(0, 7) as $uIdx) {
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cKharidar,     'days' => rand(1, 4),   'prog' => rand(65, 95)]; // Hot trending
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cIq,           'days' => rand(2, 6),   'prog' => rand(70, 100)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cNaSu,         'days' => rand(3, 8),   'prog' => rand(40, 75)];
            if ($uIdx % 2 === 0) {
                $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cComputer, 'days' => rand(10, 20), 'prog' => rand(50, 80)];
            }
        }

        // Group 2 (Users 8-17)
        foreach (range(8, 17) as $uIdx) {
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cNaSu,         'days' => rand(1, 5),   'prog' => rand(80, 100)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cOfficer,      'days' => rand(2, 7),   'prog' => rand(50, 85)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cConstitution, 'days' => rand(4, 12),  'prog' => rand(60, 95)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cIq,           'days' => rand(8, 18),  'prog' => rand(85, 100)];
        }

        // Group 3 (Users 18-24)
        foreach (range(18, 24) as $uIdx) {
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cNrbOfficer,   'days' => rand(3, 9),   'prog' => rand(70, 95)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cNrbAd,        'days' => rand(5, 14),  'prog' => rand(45, 80)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cConstitution, 'days' => rand(6, 16),  'prog' => rand(75, 100)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cIq,           'days' => rand(12, 22), 'prog' => rand(80, 100)];
        }

        // Group 4 (Users 25-29) - Cross-Track / Comprehensive
        foreach (range(25, 29) as $uIdx) {
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cKharidar,     'days' => rand(1, 3),   'prog' => 100];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cOfficer,      'days' => rand(2, 6),   'prog' => rand(85, 95)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cNrbOfficer,   'days' => rand(7, 15),  'prog' => rand(70, 90)];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cComputer,     'days' => rand(15, 28), 'prog' => 100];
            $enrollmentPlan[] = ['user' => $uIdx, 'course' => $cConstitution, 'days' => rand(10, 20), 'prog' => 90];
        }

        $created = 0;
        foreach ($enrollmentPlan as $plan) {
            $user = $students[$plan['user']] ?? null;
            $courseId = $plan['course'];
            if (! $user || ! $courseId) {
                continue;
            }

            $status = $plan['prog'] >= 100 ? 'completed' : 'active';

            $enrollment = Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $courseId,
                'status' => $status,
                'progress_percentage' => $plan['prog'],
            ]);

            // Backdate created_at for Gravity Decay curve
            $enrollment->created_at = $now->copy()->subDays($plan['days'])->subHours(rand(1, 20));
            $enrollment->save();
            $created++;
        }

        // Add demo pending enrollments awaiting admin verification
        $pendingPlans = [
            ['user' => 0, 'course' => $cOfficer],
            ['user' => 1, 'course' => $cNrbOfficer],
            ['user' => 2, 'course' => $cNrbAd],
        ];

        foreach ($pendingPlans as $pPlan) {
            $user = $students[$pPlan['user']] ?? null;
            $courseId = $pPlan['course'];
            if ($user && $courseId && ! Enrollment::where('user_id', $user->id)->where('course_id', $courseId)->exists()) {
                Enrollment::create([
                    'user_id' => $user->id,
                    'course_id' => $courseId,
                    'status' => 'pending',
                    'progress_percentage' => 0,
                    'created_at' => $now->copy()->subHours(rand(1, 12)),
                ]);
                $created++;
            }
        }

        $this->command->info("   ✅ Seeded {$created} structured enrollments across 30 users");
    }

    private function seedLessonProgressAndPacing($students, $lessonsByCourse): void
    {
        $now = Carbon::now();
        $createdCount = 0;

        foreach ($students as $student) {
            $paceMultiplier = (float) ($student->learning_pace_multiplier ?? 1.0);
            $enrollments = Enrollment::where('user_id', $student->id)->get();

            foreach ($enrollments as $enrollment) {
                $lessons = $lessonsByCourse->get($enrollment->course_id);
                if (! $lessons || $lessons->isEmpty()) {
                    continue;
                }

                $totalLessons = $lessons->count();
                $targetProg = (int) ($enrollment->progress_percentage ?? 0);
                $completedLessonCount = max(0, min($totalLessons, (int) round(($targetProg / 100) * $totalLessons)));

                // If user has a non-zero progress plan and total lessons exist, ensure at least 1 lesson
                if ($targetProg > 0 && $completedLessonCount === 0 && $totalLessons > 0) {
                    $completedLessonCount = 1;
                }

                $completedLessons = $lessons->take($completedLessonCount);

                // Baseline interval between lesson completions in hours (scaled by student pace)
                $hoursPerLesson = max(2, (int) round(12 * $paceMultiplier));
                $startHourOffset = $completedLessonCount * $hoursPerLesson;
                $startTime = $now->copy()->subHours($startHourOffset);

                foreach ($completedLessons as $idx => $lesson) {
                    $completedAt = $startTime->copy()->addHours($idx * $hoursPerLesson + rand(0, 3));
                    if ($completedAt->isAfter($now)) {
                        $completedAt = $now->copy()->subMinutes(rand(10, 180));
                    }

                    // SM-2 Spaced Repetition Parameters Distribution
                    // 50% easy, 30% medium, 20% hard
                    $randDifficulty = rand(1, 100);
                    if ($randDifficulty <= 50) {
                        // Easy item: high EF, longer interval
                        $ef = round(rand(250, 300) / 100, 2);
                        $interval = rand(8, 30);
                        $reps = rand(3, 7);
                        $nextReview = $now->copy()->addDays(rand(7, 30));
                    } elseif ($randDifficulty <= 80) {
                        // Medium item: standard EF, upcoming review
                        $ef = round(rand(190, 240) / 100, 2);
                        $interval = rand(2, 6);
                        $reps = rand(1, 3);
                        $nextReview = $now->copy()->addDays(rand(1, 6));
                    } else {
                        // Hard item: lower EF, due today or overdue
                        $ef = round(rand(130, 180) / 100, 2);
                        $interval = 1;
                        $reps = rand(0, 1);
                        $nextReview = $now->copy()->subDays(rand(0, 3)); // Overdue / Due today
                    }

                    LessonProgress::create([
                        'user_id' => $student->id,
                        'lesson_id' => $lesson->id,
                        'completed_at' => $completedAt,
                        'easiness_factor' => $ef,
                        'interval' => $interval,
                        'repetitions' => $reps,
                        'next_review_date' => $nextReview,
                    ]);

                    $createdCount++;
                }

                // Synchronize exact calculated progress percentage on enrollment
                $actualProgress = $totalLessons > 0 ? (int) round(($completedLessonCount / $totalLessons) * 100) : 0;
                $enrollment->update([
                    'progress_percentage' => $actualProgress,
                    'status' => $actualProgress >= 100 ? 'completed' : 'active',
                ]);
            }
        }

        $this->command->info("   ✅ Seeded {$createdCount} lesson progress records with SM-2 parameters & pacing timestamps");
    }

    private function calculateTrending(): void
    {
        /** @var TrendingService $trendingService */
        $trendingService = app(TrendingService::class);
        $trendingService->calculateTrendingScores();
        $this->command->info('   ✅ Calculated trending gravity scores for all courses');
    }
}
