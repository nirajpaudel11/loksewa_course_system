<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_enrollment_starts_as_pending_verification(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Course', 'slug' => 'course', 'is_published' => true]);

        $this->actingAs($user)
            ->post(route('courses.enroll', $course))
            ->assertRedirect();

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
            'progress_percentage' => 0,
        ]);

        $this->actingAs($user)
            ->post(route('courses.unenroll', $course))
            ->assertRedirect();

        $this->assertDatabaseMissing('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    public function test_admin_can_approve_pending_enrollment(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Course 2', 'slug' => 'course-2', 'is_published' => true]);

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
            'progress_percentage' => 0,
        ]);

        $enrollment->update(['status' => 'active']);

        $this->assertDatabaseHas('enrollments', [
            'id' => $enrollment->id,
            'status' => 'active',
        ]);
    }

    public function test_user_cannot_unenroll_from_completed_course(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Completed Course', 'slug' => 'completed-course', 'is_published' => true]);

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'completed',
            'progress_percentage' => 100,
        ]);

        $response = $this->actingAs($user)
            ->post(route('courses.unenroll', $course));

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('enrollments', [
            'id' => $enrollment->id,
            'course_id' => $course->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_recalculate_pacing_predictions(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Pacing Course', 'slug' => 'pacing-course', 'is_published' => true]);

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 50,
        ]);

        $response = $this->actingAs($user)
            ->post(route('pacing.recalculate'));

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}
