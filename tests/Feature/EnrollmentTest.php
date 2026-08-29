<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_enroll_and_unenroll_from_course(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Course', 'slug' => 'course', 'is_published' => true]);

        $this->actingAs($user)
            ->post(route('courses.enroll', $course))
            ->assertRedirect();

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
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
}
