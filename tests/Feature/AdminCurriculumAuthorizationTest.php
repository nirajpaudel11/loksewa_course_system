<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminCurriculumAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_user_cannot_create_curriculum_from_frontend_route(): void
    {
        $user = User::factory()->create();
        $course = Course::create(['title' => 'Course', 'slug' => 'course', 'is_published' => true]);

        $this->actingAs($user)
            ->post(route('admin.modules.add', $course), ['title' => 'Blocked Module'])
            ->assertForbidden();

        $this->assertDatabaseMissing('modules', ['title' => 'Blocked Module']);
    }

    public function test_admin_user_can_create_curriculum_from_frontend_route(): void
    {
        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');
        $course = Course::create(['title' => 'Course', 'slug' => 'course', 'is_published' => true]);

        $this->actingAs($admin)
            ->post(route('admin.modules.add', $course), ['title' => 'Allowed Module'])
            ->assertRedirect();

        $this->assertDatabaseHas('modules', ['title' => 'Allowed Module', 'slug' => 'allowed-module']);
    }
}
