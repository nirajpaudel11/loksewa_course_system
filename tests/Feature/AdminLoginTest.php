<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_admin_login_page_without_brand_logo_image(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Loksewa Path');
        $response->assertSee('Sign in');

        // Confirm brand logo image from previous custom brand-logo component is not rendered on the login header
        $response->assertDontSee('alt="Loksewa LMS"', false);
    }

    public function test_admin_user_can_access_admin_dashboard_after_login(): void
    {
        Role::create(['name' => 'admin']);
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->get('/admin');
        $response->assertStatus(200);
    }
}
