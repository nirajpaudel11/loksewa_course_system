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
use Illuminate\Support\Facades\Hash;

/**
 * Seeds realistic demo data to exercise all 6 algorithms in the Algorithm Report.
 *
 * Algorithms covered:
 * 1. DAG / Topological Sort  — prerequisite edges are already seeded in LoksewaContentSeeder
 * 2. Trending (Gravity Decay) — enrollments spread across different dates for score variance
 * 3. Collaborative Filtering — overlapping enrollment patterns between users
 * 4. Content Similarity (TF-IDF) — course descriptions are already seeded with real Loksewa text
 * 5. Spaced Repetition (SM-2) — lesson_progress rows with easiness_factor & next_review_date
 * 6. Learning Pacing — sequential completed_at timestamps to compute pace
 *
 * Run: php artisan db:seed --class=AlgorithmDemoSeeder
 */
class AlgorithmDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Seeding Algorithm Demo Data...');

        // ── 1. Create demo students ──────────────────────────────────
        $students = $this->createStudents();
        $this->command->info('   ✅ Created ' . count($students) . ' demo students');

        // ── 2. Get all courses & lessons ──────────────────────────────
        $courses = Course::all();
        if ($courses->isEmpty()) {
            $this->command->error('   ❌ No courses found. Run LoksewaContentSeeder first.');
            return;
        }

        $allLessons = Lesson::all()->groupBy(function ($lesson) {
            // Group lessons by course via chapter -> module -> course chain
            $chapter = $lesson->chapter;
            if (!$chapter) return null;
            $module = $chapter->module;
            if (!$module) return null;
            return $module->course_id;
        })->filter();

        $this->command->info('   📚 Found ' . $courses->count() . ' courses with lessons in ' . $allLessons->count() . ' courses');

        // ── 3. Seed Enrollments (feeds Trending + Collaborative Filtering) ─
        $this->seedEnrollments($students, $courses);
        $this->command->info('   ✅ Seeded enrollments with varied dates');

        // ── 4. Seed Lesson Progress (feeds Spaced Repetition + Learning Pacing) ─
        $this->seedLessonProgress($students, $allLessons);
        $this->command->info('   ✅ Seeded lesson progress with SM-2 data');

        // ── 5. Calculate Trending Scores ──────────────────────────────
        $this->calculateTrending();
        $this->command->info('   ✅ Calculated trending scores');

        // ── 6. Set Learning Pace Multipliers ─────────────────────────
        $this->setLearningPaces($students);
        $this->command->info('   ✅ Set learning pace multipliers');

        $this->command->newLine();
        $this->command->info('🎉 Algorithm Demo Data seeded successfully!');
        $this->command->info('   Visit admin/algorithm-report to see the results.');
    }

    /**
     * Create 15 demo student users with unique Nepali names.
     */
    private function createStudents(): array
    {
        $studentData = [
            ['name' => 'Aarav Sharma',     'email' => 'aarav.sharma@demo.test'],
            ['name' => 'Bikash Thapa',     'email' => 'bikash.thapa@demo.test'],
            ['name' => 'Chandani Gurung',  'email' => 'chandani.gurung@demo.test'],
            ['name' => 'Deepak Adhikari',  'email' => 'deepak.adhikari@demo.test'],
            ['name' => 'Elina Maharjan',   'email' => 'elina.maharjan@demo.test'],
            ['name' => 'Firoz Magar',      'email' => 'firoz.magar@demo.test'],
            ['name' => 'Gita Basnet',      'email' => 'gita.basnet@demo.test'],
            ['name' => 'Hari Koirala',     'email' => 'hari.koirala@demo.test'],
            ['name' => 'Isha Pandey',      'email' => 'isha.pandey@demo.test'],
            ['name' => 'Jeevan Rai',       'email' => 'jeevan.rai@demo.test'],
            ['name' => 'Kabita Shrestha',  'email' => 'kabita.shrestha@demo.test'],
            ['name' => 'Laxmi Bhatt',      'email' => 'laxmi.bhatt@demo.test'],
            ['name' => 'Manish Tamang',    'email' => 'manish.tamang@demo.test'],
            ['name' => 'Nisha Dhakal',     'email' => 'nisha.dhakal@demo.test'],
            ['name' => 'Om Prasad Poudel', 'email' => 'om.poudel@demo.test'],
        ];

        $students = [];

        foreach ($studentData as $data) {
            $students[] = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                ]
            );
        }

        return $students;
    }

    /**
     * Seed enrollments with varied dates to create interesting trending & collaborative data.
     *
     * Strategy for Collaborative Filtering:
     *   - Group A (users 0-4): Enrolled in courses 1,2,3 (Nayab Subba + NRB pair)
     *   - Group B (users 5-9): Enrolled in courses 1,4,5 (General admin track)
     *   - Group C (users 10-14): Enrolled in courses 2,3,5 (Banking + entry)
     *   - Overlaps ensure Jaccard similarity produces meaningful recommendations.
     *
     * Strategy for Trending:
     *   - Recent enrollments (1-5 days) for courses 1,2  → high trending
     *   - Mid-range (10-20 days) for courses 3,4         → medium trending
     *   - Old (25-30 days) for course 5                  → low trending
     */
    private function seedEnrollments(array $students, $courses): void
    {
        // Don't duplicate: remove old demo enrollments
        $studentIds = collect($students)->pluck('id')->toArray();
        Enrollment::whereIn('user_id', $studentIds)->delete();

        $courseIds = $courses->pluck('id')->toArray();

        // Define enrollment matrix: [student_index => [course_id, days_ago]]
        $enrollmentMatrix = [];

        // Group A: users 0-4 → courses at index 0,1,2
        foreach (range(0, 4) as $i) {
            if (isset($courseIds[0])) $enrollmentMatrix[] = [$i, $courseIds[0], rand(1, 3)];   // very recent
            if (isset($courseIds[1])) $enrollmentMatrix[] = [$i, $courseIds[1], rand(1, 5)];   // very recent
            if (isset($courseIds[2])) $enrollmentMatrix[] = [$i, $courseIds[2], rand(10, 15)]; // mid-range
        }

        // Group B: users 5-9 → courses at index 0,3,4
        foreach (range(5, 9) as $i) {
            if (isset($courseIds[0])) $enrollmentMatrix[] = [$i, $courseIds[0], rand(2, 7)];   // recent
            if (isset($courseIds[3])) $enrollmentMatrix[] = [$i, $courseIds[3], rand(12, 20)]; // mid-range
            if (isset($courseIds[4])) $enrollmentMatrix[] = [$i, $courseIds[4], rand(25, 30)]; // old
        }

        // Group C: users 10-14 → courses at index 1,2,4
        foreach (range(10, 14) as $i) {
            if (isset($courseIds[1])) $enrollmentMatrix[] = [$i, $courseIds[1], rand(1, 4)];   // very recent
            if (isset($courseIds[2])) $enrollmentMatrix[] = [$i, $courseIds[2], rand(8, 14)];  // mid-range
            if (isset($courseIds[4])) $enrollmentMatrix[] = [$i, $courseIds[4], rand(20, 28)]; // older
        }

        // Also add some cross-group enrollments for richer CF data
        // Users 0,1 also enroll in course 4 (so Group A overlaps with Group B)
        if (isset($courseIds[3])) {
            $enrollmentMatrix[] = [0, $courseIds[3], rand(5, 10)];
            $enrollmentMatrix[] = [1, $courseIds[3], rand(5, 10)];
        }
        // Users 5,6 also enroll in course 2 (Group B overlaps with Group C)
        if (isset($courseIds[1])) {
            $enrollmentMatrix[] = [5, $courseIds[1], rand(3, 8)];
            $enrollmentMatrix[] = [6, $courseIds[1], rand(3, 8)];
        }

        // Additional enrollments from CourseContentSeeder courses (IDs > 5) if they exist
        $extraCourses = $courses->where('id', '>', 5)->values();
        foreach ($extraCourses as $idx => $ec) {
            // Spread demo students across extra courses for more data
            foreach (range($idx % 5, min(14, ($idx % 5) + 4)) as $si) {
                if (isset($students[$si])) {
                    $enrollmentMatrix[] = [$si, $ec->id, rand(1, 25)];
                }
            }
        }

        $created = 0;
        foreach ($enrollmentMatrix as [$studentIdx, $courseId, $daysAgo]) {
            if (!isset($students[$studentIdx])) continue;

            $exists = Enrollment::where('user_id', $students[$studentIdx]->id)
                ->where('course_id', $courseId)
                ->exists();

            if ($exists) continue;

            $progressPct = rand(10, 95);
            $status = $progressPct >= 90 ? 'completed' : 'active';

            $enrollment = Enrollment::create([
                'user_id'             => $students[$studentIdx]->id,
                'course_id'           => $courseId,
                'status'              => $status,
                'progress_percentage' => $progressPct,
            ]);

            // Backdate created_at for trending algorithm variation
            $enrollment->created_at = Carbon::now()->subDays($daysAgo)->subHours(rand(0, 23));
            $enrollment->save();

            $created++;
        }

        $this->command->info("     → {$created} enrollments created across " . count($courseIds) . " courses");
    }

    /**
     * Seed lesson progress data feeding both Spaced Repetition (SM-2) and Learning Pacing.
     *
     * - Creates completed_at timestamps spaced realistically (2-36 hours apart)
     * - Sets SM-2 parameters: easiness_factor varies (easy/medium/hard distribution)
     * - Sets next_review_date: some due today, some upcoming, some future
     */
    private function seedLessonProgress(array $students, $lessonsByCourse): void
    {
        // Remove old demo lesson progress
        $studentIds = collect($students)->pluck('id')->toArray();
        LessonProgress::whereIn('user_id', $studentIds)->delete();

        $now = Carbon::now();
        $created = 0;

        // SM-2 difficulty presets
        $difficultyPresets = [
            // [easiness_factor, interval_days, repetitions, review_offset_days]
            'easy'   => ['ef_min' => 2.5, 'ef_max' => 3.0, 'interval' => [6, 15, 30],  'reps' => [3, 5, 8]],
            'medium' => ['ef_min' => 1.8, 'ef_max' => 2.4, 'interval' => [1, 3, 6],    'reps' => [1, 2, 3]],
            'hard'   => ['ef_min' => 1.3, 'ef_max' => 1.7, 'interval' => [1, 1, 2],    'reps' => [0, 1, 1]],
        ];

        foreach ($students as $sIdx => $student) {
            // Get enrollments for this student
            $enrollments = Enrollment::where('user_id', $student->id)->pluck('course_id')->toArray();

            foreach ($enrollments as $courseId) {
                if (!isset($lessonsByCourse[$courseId])) continue;

                $lessons = $lessonsByCourse[$courseId]->values();
                if ($lessons->isEmpty()) continue;

                // Determine how many lessons this student has completed (60-100%)
                $completionRatio = rand(60, 100) / 100;
                $completedCount  = max(1, (int) floor($lessons->count() * $completionRatio));
                $lessonsToComplete = $lessons->take($completedCount);

                // Determine student's pace (hours between lessons)
                // Fast learner = 2-6h, Normal = 8-18h, Slow = 20-36h
                $paceProfiles = [
                    ['min' => 2, 'max' => 6],   // fast
                    ['min' => 8, 'max' => 18],  // normal
                    ['min' => 20, 'max' => 36],  // slow
                ];
                $pace = $paceProfiles[$sIdx % 3];

                // Start time: backdate from now
                $totalHours = $completedCount * (($pace['min'] + $pace['max']) / 2);
                $startTime = $now->copy()->subHours((int) $totalHours);

                foreach ($lessonsToComplete as $lIdx => $lesson) {
                    // Calculate completion time
                    $hoursGap = $lIdx === 0 ? 0 : rand($pace['min'], $pace['max']);
                    $completedAt = $startTime->copy()->addHours($hoursGap * ($lIdx + 1));

                    // Don't create future completions
                    if ($completedAt->isAfter($now)) {
                        $completedAt = $now->copy()->subMinutes(rand(10, 120));
                    }

                    // SM-2 difficulty assignment: distribute across easy/medium/hard
                    $roll = rand(1, 100);
                    if ($roll <= 50) {
                        $diff = 'easy';
                    } elseif ($roll <= 80) {
                        $diff = 'medium';
                    } else {
                        $diff = 'hard';
                    }
                    $preset = $difficultyPresets[$diff];

                    $ef = round(rand($preset['ef_min'] * 100, $preset['ef_max'] * 100) / 100, 2);
                    $interval = $preset['interval'][array_rand($preset['interval'])];
                    $reps = $preset['reps'][array_rand($preset['reps'])];

                    // Review date: some past-due, some upcoming, some far future
                    $reviewRoll = rand(1, 100);
                    if ($reviewRoll <= 25) {
                        // Due today or overdue (past)
                        $nextReview = $now->copy()->subDays(rand(0, 3));
                    } elseif ($reviewRoll <= 60) {
                        // Upcoming 7 days
                        $nextReview = $now->copy()->addDays(rand(1, 7));
                    } else {
                        // Future (8-60 days)
                        $nextReview = $now->copy()->addDays(rand(8, 60));
                    }

                    LessonProgress::create([
                        'user_id'          => $student->id,
                        'lesson_id'        => $lesson->id,
                        'completed_at'     => $completedAt,
                        'easiness_factor'  => $ef,
                        'interval'         => $interval,
                        'repetitions'      => $reps,
                        'next_review_date' => $nextReview,
                    ]);

                    $created++;
                }
            }
        }

        $this->command->info("     → {$created} lesson progress records with SM-2 data");
    }

    /**
     * Run the TrendingService to calculate scores based on newly seeded enrollments.
     */
    private function calculateTrending(): void
    {
        $trendingService = app(TrendingService::class);
        $trendingService->calculateTrendingScores();
    }

    /**
     * Set varied learning_pace_multiplier on students to populate the Learning Pacing section.
     */
    private function setLearningPaces(array $students): void
    {
        $paces = [0.3, 0.5, 0.6, 0.75, 0.8, 1.0, 1.0, 1.1, 1.3, 1.5, 1.8, 2.0, 0.4, 0.9, 1.2];

        foreach ($students as $i => $student) {
            $student->learning_pace_multiplier = $paces[$i % count($paces)];
            $student->save();
        }
    }
}
