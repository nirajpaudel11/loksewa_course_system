<?php

namespace Tests\Feature;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module as CourseModule;
use App\Models\User;
use Database\Seeders\NeaLevel4CourseSeeder;
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

    public function test_legacy_or_modified_slug_redirects_to_matching_authentic_lesson(): void
    {
        $user = User::factory()->create();
        $course = $this->createCourseWithLesson('nayab-subba-tayari', 'nasu-geography-of-nepal', 'Geography of Nepal');

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($user)
            ->get(route('lessons.show', ['nayab-subba-tayari', 'physical-geography-of-nepal-5']))
            ->assertRedirect(route('lessons.show', ['nayab-subba-tayari', 'nasu-geography-of-nepal']));
    }


    public function test_pending_enrolled_user_cannot_access_lesson_until_approved(): void
    {
        $user = User::factory()->create();
        $course = $this->createCourseWithLesson('course-p', 'lesson-p');
        $lesson = $course->modules()->first()->chapters()->first()->lessons()->first();

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($user)
            ->get(route('lessons.show', [$course->slug, $lesson->slug]))
            ->assertRedirect(route('courses.details', $course->slug))
            ->assertSessionHas('warning');
    }

    public function test_lesson_with_quiz_cannot_be_completed_without_finishing_quiz(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Quiz Course', 'slug' => 'quiz-course', 'is_published' => true]);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => 'Quiz Module', 'slug' => 'quiz-module', 'order' => 1]);
        $chapter = Chapter::create(['module_id' => $module->id, 'title' => 'Quiz Chapter', 'slug' => 'quiz-chapter', 'order' => 1]);
        $quizLesson = Lesson::create([
            'chapter_id' => $chapter->id,
            'title' => 'Quiz Lesson',
            'slug' => 'quiz-lesson',
            'order' => 1,
            'type' => 'quiz',
            'quiz_questions' => [
                [
                    'question' => 'Sample Loksewa MCQ?',
                    'options' => ['A', 'B', 'C', 'D'],
                    'answer' => 0,
                    'hint' => 'Hint text',
                    'explanation' => 'Explanation text',
                ],
            ],
            'is_published' => true,
        ]);

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        // Attempt completion without quiz_completed flag
        $this->actingAs($user)
            ->post(route('lessons.complete', [$course->slug, $quizLesson->slug]))
            ->assertRedirect(route('lessons.show', [$course->slug, $quizLesson->slug]))
            ->assertSessionHas('warning');

        $this->assertDatabaseMissing('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $quizLesson->id,
        ]);

        // Now complete with quiz_completed flag
        $this->actingAs($user)
            ->post(route('lessons.complete', [$course->slug, $quizLesson->slug]), [
                'quiz_completed' => 1,
                'quiz_score' => 1,
                'quiz_total' => 1,
            ])
            ->assertRedirect(route('courses.details', $course->slug))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $quizLesson->id,
        ]);
    }

    public function test_nea_level_4_lesson_loads_quiz_questions(): void
    {
        $this->seed(NeaLevel4CourseSeeder::class);

        $course = Course::where('slug', 'nea-level-4')->first();
        $this->assertNotNull($course);

        $lesson = $course->modules()->first()->chapters()->first()->lessons()->first();
        $this->assertNotNull($lesson);
        $this->assertCount(10, $lesson->quiz_questions);

        $user = User::factory()->create();
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        $response = $this->actingAs($user)
            ->get(route('lessons.show', [$course->slug, $lesson->slug]))
            ->assertOk();

        $response->assertSee('GK / IQ Practice Quiz');
        $response->assertSee('Question 1 of 10');
    }

    public function test_user_cannot_access_subsequent_lesson_without_completing_prior_lesson(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Sequential Course', 'slug' => 'seq-course', 'is_published' => true]);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => 'Module 1', 'slug' => 'm1', 'order' => 1]);
        $chapter = Chapter::create(['module_id' => $module->id, 'title' => 'Chapter 1', 'slug' => 'c1', 'order' => 1]);
        $lesson1 = Lesson::create(['chapter_id' => $chapter->id, 'title' => 'Lesson 1', 'slug' => 'lesson-1', 'order' => 1, 'content' => 'Content 1', 'is_published' => true]);
        $lesson2 = Lesson::create(['chapter_id' => $chapter->id, 'title' => 'Lesson 2', 'slug' => 'lesson-2', 'order' => 2, 'content' => 'Content 2', 'is_published' => true]);

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        // Attempting to access Lesson 2 while Lesson 1 is incomplete should redirect to Lesson 1
        $this->actingAs($user)
            ->get(route('lessons.show', [$course->slug, $lesson2->slug]))
            ->assertRedirect(route('lessons.show', [$course->slug, $lesson1->slug]))
            ->assertSessionHas('warning');

        // Accessing Lesson 1 directly should succeed (200 OK)
        $this->actingAs($user)
            ->get(route('lessons.show', [$course->slug, $lesson1->slug]))
            ->assertOk();
    }

    public function test_user_cannot_complete_subsequent_lesson_out_of_order(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Seq Complete Course', 'slug' => 'seq-comp-course', 'is_published' => true]);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => 'Module 1', 'slug' => 'm1-comp', 'order' => 1]);
        $chapter = Chapter::create(['module_id' => $module->id, 'title' => 'Chapter 1', 'slug' => 'c1-comp', 'order' => 1]);
        $lesson1 = Lesson::create(['chapter_id' => $chapter->id, 'title' => 'Lesson 1', 'slug' => 'l1', 'order' => 1, 'content' => 'Content 1', 'is_published' => true]);
        $lesson2 = Lesson::create(['chapter_id' => $chapter->id, 'title' => 'Lesson 2', 'slug' => 'l2', 'order' => 2, 'content' => 'Content 2', 'is_published' => true]);

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        // Attempting to complete Lesson 2 without completing Lesson 1 first should be rejected
        $this->actingAs($user)
            ->post(route('lessons.complete', [$course->slug, $lesson2->slug]))
            ->assertRedirect(route('lessons.show', [$course->slug, $lesson1->slug]))
            ->assertSessionHas('warning');

        $this->assertDatabaseMissing('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $lesson2->id,
        ]);

        // Complete Lesson 1 successfully
        $this->actingAs($user)
            ->post(route('lessons.complete', [$course->slug, $lesson1->slug]))
            ->assertRedirect(route('lessons.show', [$course->slug, $lesson2->slug]))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $lesson1->id,
        ]);

        // Now Lesson 2 can be accessed and completed
        $this->actingAs($user)
            ->get(route('lessons.show', [$course->slug, $lesson2->slug]))
            ->assertOk();

        $this->actingAs($user)
            ->post(route('lessons.complete', [$course->slug, $lesson2->slug]))
            ->assertRedirect(route('courses.details', $course->slug))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $lesson2->id,
        ]);
    }

    private function createCourseWithLesson(string $courseSlug, string $lessonSlug, ?string $lessonTitle = null): Course
    {
        $course = Course::create(['title' => $courseSlug, 'slug' => $courseSlug, 'is_published' => true]);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => "{$courseSlug} Module", 'slug' => "{$courseSlug}-module", 'order' => 1]);
        $chapter = Chapter::create(['module_id' => $module->id, 'title' => "{$courseSlug} Chapter", 'slug' => "{$courseSlug}-chapter", 'order' => 1]);
        Lesson::create(['chapter_id' => $chapter->id, 'title' => $lessonTitle ?? $lessonSlug, 'slug' => $lessonSlug, 'order' => 1, 'content' => 'Text', 'is_published' => true]);

        return $course;
    }
}
