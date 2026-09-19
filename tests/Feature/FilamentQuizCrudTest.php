<?php

namespace Tests\Feature;

use App\Filament\Resources\Lessons\Pages\CreateLesson;
use App\Filament\Resources\Lessons\Pages\EditLesson;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FilamentQuizCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_dynamic_quiz_lesson(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);

        $course = Course::create([
            'title' => 'Test Course',
            'slug' => 'test-course',
            'is_published' => true,
        ]);
        $module = Module::create([
            'course_id' => $course->id,
            'title' => 'Test Module',
            'slug' => 'test-module',
            'order' => 1,
        ]);

        $this->actingAs($admin);

        Livewire::test(CreateLesson::class)
            ->fillForm([
                'module_id' => $module->id,
                'title' => 'Dynamic Geography Quiz',
                'slug' => 'dynamic-geography-quiz',
                'type' => 'quiz',
                'duration_minutes' => 15,
                'order' => 1,
                'is_published' => true,
                'quiz_questions' => [
                    [
                        'question' => 'What is the capital of Gandaki Pradesh?',
                        'option_0' => 'Kathmandu',
                        'option_1' => 'Pokhara',
                        'option_2' => 'Biratnagar',
                        'option_3' => 'Janakpur',
                        'answer' => 1,
                        'explanation' => 'Pokhara is the administrative capital of Gandaki Province.',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $lesson = Lesson::where('slug', 'dynamic-geography-quiz')->first();
        $this->assertNotNull($lesson);
        $this->assertEquals('quiz', $lesson->type);
        $this->assertEquals($module->id, $lesson->module_id);

        $decoded = json_decode($lesson->content, true);
        $this->assertIsArray($decoded);
        $this->assertCount(1, $decoded);
        $this->assertEquals('What is the capital of Gandaki Pradesh?', $decoded[0]['question']);
        $this->assertEquals('Pokhara', $decoded[0]['options'][1]);
        $this->assertEquals(1, $decoded[0]['answer']);
    }

    public function test_admin_can_edit_dynamic_quiz_questions(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);

        $course = Course::create([
            'title' => 'Test Course 2',
            'slug' => 'test-course-2',
            'is_published' => true,
        ]);
        $module = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 2',
            'slug' => 'module-2',
            'order' => 1,
        ]);

        $initialQuiz = [
            [
                'question' => 'Initial Question?',
                'options' => ['A', 'B', 'C', 'D'],
                'answer' => 0,
                'explanation' => 'Initial explanation',
            ],
        ];

        $lesson = Lesson::create([
            'module_id' => $module->id,
            'title' => 'Editable Quiz',
            'slug' => 'editable-quiz',
            'type' => 'quiz',
            'content' => json_encode($initialQuiz),
            'order' => 1,
            'is_published' => true,
        ]);

        $this->actingAs($admin);

        Livewire::test(EditLesson::class, ['record' => $lesson->id])
            ->assertFormFieldExists('quiz_questions')
            ->fillForm([
                'module_id' => $module->id,
                'title' => 'Updated Quiz Title',
                'quiz_questions' => [
                    [
                        'question' => 'Updated Question 1?',
                        'option_0' => 'Choice 1',
                        'option_1' => 'Choice 2',
                        'option_2' => 'Choice 3',
                        'option_3' => 'Choice 4',
                        'answer' => 2,
                        'explanation' => 'Updated explanation text',
                    ],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $lesson->refresh();
        $this->assertEquals('Updated Quiz Title', $lesson->title);

        $decoded = json_decode($lesson->content, true);
        $this->assertIsArray($decoded);
        $this->assertEquals('Updated Question 1?', $decoded[0]['question']);
        $this->assertEquals('Choice 3', $decoded[0]['options'][2]);
        $this->assertEquals(2, $decoded[0]['answer']);
    }
}
