<?php

namespace App\Filament\Resources\Modules\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Modules\ModuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditModule extends EditRecord
{
    protected static string $resource = ModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $module = $this->getRecord();
        $course = $module?->course;

        $breadcrumbs = [];

        if ($course) {
            $breadcrumbs[CourseResource::getUrl('edit', ['record' => $course])] = $course->title;
        }

        $breadcrumbs[] = $module?->title ?? 'Module';

        return $breadcrumbs;
    }
}
