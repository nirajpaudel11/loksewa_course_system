<?php

namespace Tests\Unit;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Module;
use App\Models\User;
use App\Services\LearningPacingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningPacingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_predicts_completion_date_for_user_with_progress(): void
    {
        $user = User::factory()->create([
            'learning_pace_multiplier' => 0.8,
        ]);

        $course = Course::create([
            'title' => 'Test Loksewa Course',
            'slug' => 'test-loksewa-course',
            'is_published' => true,
        ]);
        $module = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 1',
            'slug' => 'module-1',
            'order' => 1,
        ]);
        $chapter = Chapter::create([
            'module_id' => $module->id,
            'title' => 'Chapter 1',
            'slug' => 'chapter-1',
            'order' => 1,
        ]);

        $lessons = [];
        for ($i = 1; $i <= 6; $i++) {
            $lessons[] = Lesson::create([
                'chapter_id' => $chapter->id,
                'title' => "Lesson {$i}",
                'slug' => "lesson-{$i}",
                'type' => 'text',
                'order' => $i,
                'is_published' => true,
            ]);
        }

        // Complete 3 lessons
        $now = Carbon::now();
        LessonProgress::create([
            'user_id' => $user->id,
            'lesson_id' => $lessons[0]->id,
            'completed_at' => $now->copy()->subHours(24),
        ]);
        LessonProgress::create([
            'user_id' => $user->id,
            'lesson_id' => $lessons[1]->id,
            'completed_at' => $now->copy()->subHours(12),
        ]);
        LessonProgress::create([
            'user_id' => $user->id,
            'lesson_id' => $lessons[2]->id,
            'completed_at' => $now->copy()->subHours(2),
        ]);

        $service = app(LearningPacingService::class);
        $prediction = $service->predictCompletionDate($user, $course);

        $this->assertNotNull($prediction);
        $this->assertTrue($prediction->isFuture());
    }
}
