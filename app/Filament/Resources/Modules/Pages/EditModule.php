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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (! empty($data['quiz_questions']) && is_array($data['quiz_questions'])) {
            $formatted = [];
            foreach ($data['quiz_questions'] as $q) {
                $opts = $q['options'] ?? [];
                $formatted[] = [
                    'question' => $q['question'] ?? '',
                    'option_0' => $q['option_0'] ?? ($opts[0] ?? ''),
                    'option_1' => $q['option_1'] ?? ($opts[1] ?? ''),
                    'option_2' => $q['option_2'] ?? ($opts[2] ?? ''),
                    'option_3' => $q['option_3'] ?? ($opts[3] ?? ''),
                    'answer' => (int) ($q['answer'] ?? 0),
                    'hint' => $q['hint'] ?? '',
                    'explanation' => $q['explanation'] ?? '',
                ];
            }
            $data['quiz_questions'] = $formatted;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['quiz_questions']) && is_array($data['quiz_questions'])) {
            $questions = [];
            foreach ($data['quiz_questions'] as $q) {
                if (empty(trim($q['question'] ?? ''))) {
                    continue;
                }
                $questions[] = [
                    'question' => $q['question'] ?? '',
                    'options' => [
                        $q['option_0'] ?? '',
                        $q['option_1'] ?? '',
                        $q['option_2'] ?? '',
                        $q['option_3'] ?? '',
                    ],
                    'answer' => (int) ($q['answer'] ?? 0),
                    'hint' => $q['hint'] ?? '',
                    'explanation' => $q['explanation'] ?? '',
                ];
            }
            $data['quiz_questions'] = $questions;
        }

        return $data;
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
