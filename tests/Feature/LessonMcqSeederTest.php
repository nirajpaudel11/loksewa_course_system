<?php

namespace Tests\Feature;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module as CourseModule;
use Database\Seeders\LessonMcqSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonMcqSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_mcq_lesson_for_known_content_lesson(): void
    {
        $course = Course::create(['title' => 'Kharidar', 'slug' => 'kharidar', 'is_published' => true]);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => 'Office', 'slug' => 'office', 'order' => 1]);
        $chapter = Chapter::create(['module_id' => $module->id, 'title' => 'Filing', 'slug' => 'filing', 'order' => 1]);

        Lesson::create([
            'chapter_id' => $chapter->id,
            'title' => 'Office Filing Techniques',
            'slug' => 'office-filing-techniques',
            'type' => 'text',
            'content' => 'Filing notes',
            'order' => 1,
            'is_published' => true,
        ]);

        $this->seed(LessonMcqSeeder::class);

        $quiz = Lesson::where('slug', 'mcq-office-filing-techniques')->firstOrFail();

        $this->assertSame('quiz', $quiz->type);
        $this->assertSame('MCQ Practice: Office Filing Techniques', $quiz->title);
        $this->assertCount(5, json_decode($quiz->content, true));
    }
}
