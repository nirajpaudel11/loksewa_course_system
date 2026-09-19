<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_landing_page_at_root(): void
    {
        Course::create([
            'title' => 'Nayab Subba Preparation',
            'slug' => 'nayab-subba-preparation',
            'description' => 'Complete syllabus preparation.',
            'is_published' => true,
        ]);

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('Prepare for Loksewa with a clear course path')
            ->assertSee('Nayab Subba Preparation')
            ->assertSee('Student Sign In');
    }

    public function test_guest_cannot_open_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_catalog_uses_public_page(): void
    {
        Course::create([
            'title' => 'Officer Preparation',
            'slug' => 'officer-preparation',
            'description' => 'Public course preview.',
            'is_published' => true,
        ]);

        $this->get('/catalog')
            ->assertOk()
            ->assertSee('Browse Loksewa preparation paths')
            ->assertSee('Public Preview')
            ->assertDontSee('Explore Catalog');
    }

    public function test_guest_course_details_use_public_preview_page(): void
    {
        $course = Course::create([
            'title' => 'Kharidar Preparation',
            'slug' => 'kharidar-preparation',
            'description' => 'Public detail preview.',
            'is_published' => true,
        ]);

        $this->get(route('courses.details', $course->slug))
            ->assertOk()
            ->assertSee('Course preview')
            ->assertSee('Sign In to Start')
            ->assertDontSee('Start Preparation Now');
    }

    public function test_login_redirects_student_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'student@example.com',
            'password' => 'password',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));
    }

    public function test_authenticated_student_can_open_analytics_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('analytics'))
            ->assertOk()
            ->assertSee('Learning Analytics')
            ->assertSee('Pace Multiplier');
    }

    public function test_authenticated_student_can_open_dashboard_with_pacing_widgets(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Learning Pacing')
            ->assertSee('Exam Readiness');
    }
}
