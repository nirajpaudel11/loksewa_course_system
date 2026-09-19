<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ModuleCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_module_can_be_created_programmatically_and_has_clean_structure(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::create([
            'title' => 'Test Loksewa Course',
            'slug' => 'test-loksewa-course',
            'is_published' => true,
        ]);

        $module = Module::create([
            'course_id' => $course->id,
            'title' => 'Third Paper: Administration System',
            'slug' => 'third-paper-administration-system',
            'order' => 3,
            'is_published' => true,
            'description' => 'Comprehensive administration paper',
            'key_points' => '• Focus on Part 3',
            'notes' => 'Detailed notes',
            'quiz_questions' => [
                [
                    'question' => 'Sample Question',
                    'options' => ['A', 'B', 'C', 'D'],
                    'answer' => 0,
                    'hint' => 'Sample Hint',
                    'explanation' => 'Sample Explanation',
                ],
            ],
        ]);

        $this->assertDatabaseHas('modules', [
            'id' => $module->id,
            'title' => 'Third Paper: Administration System',
            'order' => 3,
        ]);

        $this->assertCount(1, $module->fresh()->quiz_questions);
    }
}
