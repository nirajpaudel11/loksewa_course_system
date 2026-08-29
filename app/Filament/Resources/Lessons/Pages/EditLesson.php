<?php

namespace App\Filament\Resources\Lessons\Pages;

use App\Filament\Resources\Chapters\ChapterResource;
use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Lessons\LessonResource;
use App\Filament\Resources\Modules\ModuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $lesson = $this->getRecord();
        $chapter = $lesson?->chapter;
        $module = $chapter?->module;
        $course = $module?->course;

        $breadcrumbs = [];

        if ($course) {
            $breadcrumbs[CourseResource::getUrl('edit', ['record' => $course])] = $course->title;
        }

        if ($module) {
            $breadcrumbs[ModuleResource::getUrl('edit', ['record' => $module])] = $module->title;
        }

        if ($chapter) {
            $breadcrumbs[ChapterResource::getUrl('edit', ['record' => $chapter])] = $chapter->title;
        }

        $breadcrumbs[] = $lesson?->title ?? 'Lesson';

        return $breadcrumbs;
    }
}
