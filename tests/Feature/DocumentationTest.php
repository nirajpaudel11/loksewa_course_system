<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DocumentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_documentation_pdfs_exist_and_are_accessible(): void
    {
        $adminPdfPath = public_path('storage/docs/Loksewa_Admin_and_Algorithms_Manual.pdf');
        $studentPdfPath = public_path('storage/docs/Loksewa_Student_User_Manual.pdf');

        $this->assertFileExists($adminPdfPath);
        $this->assertFileExists($studentPdfPath);
        $this->assertGreaterThan(5000, filesize($adminPdfPath));
        $this->assertGreaterThan(3000, filesize($studentPdfPath));
    }

    public function test_admin_can_open_system_documentation_page(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory()->create([
            'email' => 'admin_test@loksewa.com',
        ]);
        $admin->assignRole($adminRole);

        $response = $this->actingAs($admin)->get('/admin/system-documentation');
        $response->assertStatus(200);
        $response->assertSee('Admin Operations');
        $response->assertSee('Prerequisite');
        $response->assertSee('SuperMemo SM-2');
    }
}
