<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use App\Services\SpacedRepetitionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CourseFlashcardReviewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'user']);
    }

    public function test_it_extracts_one_mcq_from_each_lesson_of_a_course(): void
    {
        $course = Course::create([
            'title' => 'Loksewa General Knowledge Course',
            'slug' => 'loksewa-gk-course',
            'is_published' => true,
        ]);

        $module = Module::create([
            'course_id' => $course->id,
            'title' => 'Geography Module',
            'slug' => 'geography-module',
            'order' => 1,
            'is_published' => true,
        ]);

        $lesson1 = Lesson::create([
            'module_id' => $module->id,
            'title' => 'Mountains of Nepal',
            'slug' => 'mountains-of-nepal',
            'order' => 1,
            'is_published' => true,
            'quiz_questions' => [
                [
                    'question' => 'What is the height of Mt. Everest in meters?',
                    'options' => ['8848.86 m', '8611 m', '8586 m', '8516 m'],
                    'answer' => 0,
                    'explanation' => 'Mt. Everest is 8,848.86 meters high as declared jointly by Nepal and China.',
                ],
                [
                    'question' => 'Second question should not be included in single MCQ extraction',
                    'options' => ['A', 'B', 'C', 'D'],
                    'answer' => 1,
                    'explanation' => 'Extra question.',
                ],
            ],
        ]);

        $lesson2 = Lesson::create([
            'module_id' => $module->id,
            'title' => 'Rivers of Nepal',
            'slug' => 'rivers-of-nepal',
            'order' => 2,
            'is_published' => true,
            'quiz_questions' => [
                [
                    'question' => 'Which is the longest river in Nepal?',
                    'options' => ['Koshi', 'Gandaki', 'Karnali', 'Mahakali'],
                    'answer' => 2,
                    'explanation' => 'Karnali is the longest river inside Nepal (507 km).',
                ],
            ],
        ]);

        $service = app(SpacedRepetitionService::class);
        $cards = $service->extractFlashcardsForCourse($course);

        $this->assertCount(2, $cards);

        // First lesson card
        $this->assertEquals($lesson1->id, $cards[0]['lesson_id']);
        $this->assertEquals('What is the height of Mt. Everest in meters?', $cards[0]['question']);
        $this->assertEquals('8848.86 m', $cards[0]['correct_text']);

        // Second lesson card
        $this->assertEquals($lesson2->id, $cards[1]['lesson_id']);
        $this->assertEquals('Which is the longest river in Nepal?', $cards[1]['question']);
        $this->assertEquals('Karnali', $cards[1]['correct_text']);
    }

    public function test_authenticated_user_can_access_course_flashcards_view(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $course = Course::create([
            'title' => 'Section Officer Fast Track',
            'slug' => 'section-officer-fast-track',
            'is_published' => true,
        ]);

        $module = Module::create([
            'course_id' => $course->id,
            'title' => 'Governance',
            'slug' => 'governance',
            'order' => 1,
            'is_published' => true,
        ]);

        Lesson::create([
            'module_id' => $module->id,
            'title' => 'Constitutional Organs',
            'slug' => 'constitutional-organs',
            'order' => 1,
            'is_published' => true,
            'quiz_questions' => [
                [
                    'question' => 'How many constitutional organs are in the Constitution of Nepal?',
                    'options' => ['10', '13', '15', '7'],
                    'answer' => 1,
                    'explanation' => 'Part 27 defines 13 commissions/organs.',
                ],
            ],
        ]);

        $response = $this->actingAs($user)->get(route('courses.flashcards', $course->slug));

        $response->assertStatus(200);
        $response->assertSee('Constitutional Organs');
        $response->assertSee('How many constitutional organs are in the Constitution of Nepal?');
        $response->assertSee('Part 27 defines 13 commissions', false);
    }

    public function test_user_can_rate_lesson_flashcard_and_update_sm2_interval(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $course = Course::create([
            'title' => 'Nepal Administration Course',
            'slug' => 'nepal-admin-course',
            'is_published' => true,
        ]);

        $module = Module::create([
            'course_id' => $course->id,
            'title' => 'Law Module',
            'slug' => 'law-module',
            'order' => 1,
            'is_published' => true,
        ]);

        $lesson = Lesson::create([
            'module_id' => $module->id,
            'title' => 'Civil Service Act 2049',
            'slug' => 'civil-service-act-2049',
            'order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->postJson(route('lessons.rate-review', $lesson->id), [
            'quality' => 5, // Easy (Mastery)
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'lesson_id' => $lesson->id,
            'quality' => 5,
            'repetitions' => 1,
            'interval' => 1,
        ]);

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'repetitions' => 1,
            'interval' => 1,
        ]);
    }
}
