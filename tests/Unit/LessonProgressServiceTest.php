<?php

namespace Tests\Unit;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module as CourseModule;
use App\Services\LessonProgressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonProgressServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_next_lesson_moves_across_chapters_and_modules_by_order(): void
    {
        $course = Course::create(['title' => 'Course', 'slug' => 'course', 'is_published' => true]);
        $firstModule = CourseModule::create(['course_id' => $course->id, 'title' => 'First Module', 'slug' => 'first-module', 'order' => 1]);
        $secondModule = CourseModule::create(['course_id' => $course->id, 'title' => 'Second Module', 'slug' => 'second-module', 'order' => 2]);
        $firstChapter = Chapter::create(['module_id' => $firstModule->id, 'title' => 'First Chapter', 'slug' => 'first-chapter', 'order' => 1]);
        $secondChapter = Chapter::create(['module_id' => $secondModule->id, 'title' => 'Second Chapter', 'slug' => 'second-chapter', 'order' => 1]);
        $currentLesson = Lesson::create(['chapter_id' => $firstChapter->id, 'title' => 'Current', 'slug' => 'current', 'order' => 1]);
        $nextLesson = Lesson::create(['chapter_id' => $secondChapter->id, 'title' => 'Next', 'slug' => 'next', 'order' => 1]);

        $currentLesson->load('chapter.module');

        $result = app(LessonProgressService::class)->nextLesson($course, $currentLesson);

        $this->assertTrue($nextLesson->is($result));
    }
}
