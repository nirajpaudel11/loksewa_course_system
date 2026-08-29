<?php

namespace Tests\Feature;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module as CourseModule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_enrolled_user_cannot_open_lesson_from_another_course_slug(): void
    {
        $user = User::factory()->create();
        $course = $this->createCourseWithLesson('course-a', 'lesson-a');
        $otherCourse = $this->createCourseWithLesson('course-b', 'lesson-b');

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($user)
            ->get(route('lessons.show', [$course->slug, $otherCourse->modules()->first()->chapters()->first()->lessons()->first()->slug]))
            ->assertNotFound();
    }

    public function test_completing_lesson_updates_progress_and_moves_to_next_lesson(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Course', 'slug' => 'course', 'is_published' => true]);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => 'Module', 'slug' => 'module', 'order' => 1]);
        $chapter = Chapter::create(['module_id' => $module->id, 'title' => 'Chapter', 'slug' => 'chapter', 'order' => 1]);
        $firstLesson = Lesson::create(['chapter_id' => $chapter->id, 'title' => 'First', 'slug' => 'first', 'order' => 1, 'content' => 'Text', 'is_published' => true]);
        $secondLesson = Lesson::create(['chapter_id' => $chapter->id, 'title' => 'Second', 'slug' => 'second', 'order' => 2, 'content' => 'Text', 'is_published' => true]);

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($user)
            ->post(route('lessons.complete', [$course->slug, $firstLesson->slug]))
            ->assertRedirect(route('lessons.show', [$course->slug, $secondLesson->slug]));

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $firstLesson->id,
        ]);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'progress_percentage' => 50,
            'status' => 'active',
        ]);
    }

    private function createCourseWithLesson(string $courseSlug, string $lessonSlug): Course
    {
        $course = Course::create(['title' => $courseSlug, 'slug' => $courseSlug, 'is_published' => true]);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => "{$courseSlug} Module", 'slug' => "{$courseSlug}-module", 'order' => 1]);
        $chapter = Chapter::create(['module_id' => $module->id, 'title' => "{$courseSlug} Chapter", 'slug' => "{$courseSlug}-chapter", 'order' => 1]);
        Lesson::create(['chapter_id' => $chapter->id, 'title' => $lessonSlug, 'slug' => $lessonSlug, 'order' => 1, 'content' => 'Text', 'is_published' => true]);

        return $course;
    }
}
