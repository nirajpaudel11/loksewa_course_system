<?php

namespace App\Filament\Resources\Chapters\Pages;

use App\Filament\Resources\Chapters\ChapterResource;
use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Modules\ModuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChapter extends EditRecord
{
    protected static string $resource = ChapterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $chapter = $this->getRecord();
        $module = $chapter?->module;
        $course = $module?->course;

        $breadcrumbs = [];

        if ($course) {
            $breadcrumbs[CourseResource::getUrl('edit', ['record' => $course])] = $course->title;
        }

        if ($module) {
            $breadcrumbs[ModuleResource::getUrl('edit', ['record' => $module])] = $module->title;
        }

        $breadcrumbs[] = $chapter?->title ?? 'Chapter';

        return $breadcrumbs;
    }
}
