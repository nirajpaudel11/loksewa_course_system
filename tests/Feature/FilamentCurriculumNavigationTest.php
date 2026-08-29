<?php

namespace Tests\Feature;

use App\Filament\Resources\Chapters\ChapterResource;
use App\Filament\Resources\Chapters\RelationManagers\LessonsRelationManager;
use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Lessons\LessonResource;
use App\Filament\Resources\Modules\ModuleResource;
use App\Filament\Resources\Modules\RelationManagers\ChaptersRelationManager;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FilamentCurriculumNavigationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Course $course;

    protected Module $module;

    protected Chapter $chapter;

    protected Lesson $lesson;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->course = Course::create([
            'title' => 'Test Course',
            'slug' => 'test-course',
            'is_published' => true,
        ]);

        $this->module = Module::create([
            'course_id' => $this->course->id,
            'title' => 'Test Module',
            'slug' => 'test-module',
            'order' => 1,
            'is_published' => true,
        ]);

        $this->chapter = Chapter::create([
            'module_id' => $this->module->id,
            'title' => 'Test Chapter',
            'slug' => 'test-chapter',
            'order' => 1,
            'is_published' => true,
        ]);

        $this->lesson = Lesson::create([
            'chapter_id' => $this->chapter->id,
            'title' => 'Test Lesson',
            'slug' => 'test-lesson',
            'type' => 'text',
            'content' => 'Sample content',
            'order' => 1,
            'is_published' => true,
        ]);
    }

    public function test_filament_resource_urls_can_be_generated(): void
    {
        $courseUrl = CourseResource::getUrl('edit', ['record' => $this->course]);
        $moduleUrl = ModuleResource::getUrl('edit', ['record' => $this->module]);
        $chapterUrl = ChapterResource::getUrl('edit', ['record' => $this->chapter]);
        $lessonUrl = LessonResource::getUrl('edit', ['record' => $this->lesson]);

        $this->assertStringContainsString((string) $this->course->id, $courseUrl);
        $this->assertStringContainsString((string) $this->module->id, $moduleUrl);
        $this->assertStringContainsString((string) $this->chapter->id, $chapterUrl);
        $this->assertStringContainsString((string) $this->lesson->id, $lessonUrl);
    }

    public function test_module_has_chapters_relation_manager(): void
    {
        $relations = ModuleResource::getRelations();

        $this->assertContains(
            ChaptersRelationManager::class,
            $relations
        );
    }

    public function test_chapter_has_lessons_relation_manager(): void
    {
        $relations = ChapterResource::getRelations();

        $this->assertContains(
            LessonsRelationManager::class,
            $relations
        );
    }
}
