<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModuleLearningTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Course $course;

    protected Module $module;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->course = Course::create([
            'title' => 'Nayab Subba Preparation',
            'slug' => 'nayab-subba-preparation',
            'description' => 'Complete syllabus for PSC Nepal.',
            'syllabus_pdf' => 'storage/docs/Loksewa_Student_User_Manual.pdf',
            'is_published' => true,
        ]);

        $this->module = Module::create([
            'course_id' => $this->course->id,
            'title' => 'Nepal Constitution & Law',
            'slug' => 'nepal-constitution-law',
            'description' => 'Fundamental rights and constitutional organs.',
            'order' => 1,
            'pdf_file' => 'storage/docs/Loksewa_Student_User_Manual.pdf',
            'key_points' => "• Focus on Articles 16-46 (Fundamental Rights)\n• Memorize Public Service Commission functions",
            'notes' => 'Detailed theoretical coverage of the 2072 constitution.',
            'quiz_questions' => [
                [
                    'question' => 'How many fundamental rights are in Part 3 of Nepal Constitution?',
                    'options' => ['25', '31', '35', '40'],
                    'answer' => 1,
                    'hint' => 'Articles 16 to 46 define these rights.',
                    'explanation' => 'Part 3 contains 31 fundamental rights.',
                ],
            ],
            'is_published' => true,
        ]);
    }

    public function test_course_details_displays_master_syllabus_pdf_and_module_cards(): void
    {
        $this->actingAs($this->user)
            ->get(route('courses.details', $this->course->slug))
            ->assertOk()
            ->assertSee('Course Syllabus')
            ->assertSee('Nepal Constitution & Law')
            ->assertSee('Key Focus Points')
            ->assertSee('Practice Quiz (1 Qs)');
    }

    public function test_verified_student_opening_module_with_lessons_redirects_to_first_lesson(): void
    {
        $lesson = Lesson::create([
            'module_id' => $this->module->id,
            'title' => 'Geography of Nepal',
            'slug' => 'geography-of-nepal',
            'type' => 'text',
            'content' => 'Geography study content',
            'attachment_path' => 'storage/docs/Loksewa_Student_User_Manual.pdf',
            'order' => 1,
            'is_published' => true,
        ]);

        Enrollment::create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($this->user)
            ->get(route('modules.show', [$this->course->slug, $this->module->slug]))
            ->assertRedirect(route('lessons.show', [$this->course->slug, $lesson->slug]));
    }

    public function test_verified_student_can_open_module_learning_hub_when_no_lessons(): void
    {
        Enrollment::create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($this->user)
            ->get(route('modules.show', [$this->course->slug, $this->module->slug]))
            ->assertOk()
            ->assertSee('Key Points to Focus On')
            ->assertSee('Articles 16-46 (Fundamental Rights)')
            ->assertSee('Theoretical Study Notes')
            ->assertSee('Need a Hint? 💡')
            ->assertSee('Module Practice Test');
    }

    public function test_pending_enrolled_student_cannot_open_module_until_approved(): void
    {
        Enrollment::create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'status' => 'pending',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($this->user)
            ->get(route('modules.show', [$this->course->slug, $this->module->slug]))
            ->assertRedirect(route('courses.details', $this->course->slug))
            ->assertSessionHas('warning');
    }

    public function test_student_can_complete_module_and_update_progress(): void
    {
        $enrollment = Enrollment::create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($this->user)
            ->post(route('modules.complete', [$this->course->slug, $this->module->slug]))
            ->assertRedirect();

        $enrollment->refresh();
        $this->assertEquals(100, $enrollment->progress_percentage);
        $this->assertEquals('completed', $enrollment->status);
    }
}
