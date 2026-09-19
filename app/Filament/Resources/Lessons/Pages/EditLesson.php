<?php

namespace App\Filament\Resources\Lessons\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Lessons\LessonResource;
use App\Filament\Resources\Modules\ModuleResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('remove_pdf')
                ->label('Remove Attached PDF')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Remove Attached PDF Document')
                ->modalDescription('Are you sure you want to remove the current PDF document from this lesson?')
                ->visible(fn () => ! empty($this->getRecord()->attachment_path))
                ->action(function () {
                    $record = $this->getRecord();
                    if ($record->attachment_path) {
                        @Storage::disk('public')->delete($record->attachment_path);
                        $record->update(['attachment_path' => null]);
                        $this->fillForm();
                        Notification::make()
                            ->title('PDF Removed Successfully')
                            ->success()
                            ->send();
                    }
                }),
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
        } elseif (! empty($data['content'])) {
            $decoded = json_decode($data['content'], true);
            if (is_array($decoded) && isset($decoded[0]['question'])) {
                $formatted = [];
                foreach ($decoded as $q) {
                    $opts = $q['options'] ?? [];
                    $formatted[] = [
                        'question' => $q['question'] ?? '',
                        'option_0' => $opts[0] ?? '',
                        'option_1' => $opts[1] ?? '',
                        'option_2' => $opts[2] ?? '',
                        'option_3' => $opts[3] ?? '',
                        'answer' => (int) ($q['answer'] ?? 0),
                        'hint' => $q['hint'] ?? '',
                        'explanation' => $q['explanation'] ?? '',
                    ];
                }
                $data['quiz_questions'] = $formatted;
            }
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

            if (($data['type'] ?? '') === 'quiz' && count($questions) > 0) {
                $data['content'] = json_encode($questions, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        }

        return $data;
    }

    public function getBreadcrumbs(): array
    {
        $lesson = $this->getRecord();
        $module = $lesson?->module ?? $lesson?->chapter?->module;
        $course = $module?->course;

        $breadcrumbs = [];

        if ($course) {
            $breadcrumbs[CourseResource::getUrl('edit', ['record' => $course])] = $course->title;
        }

        if ($module) {
            $breadcrumbs[ModuleResource::getUrl('edit', ['record' => $module])] = $module->title;
        }

        $breadcrumbs[] = $lesson?->title ?? 'Lesson';

        return $breadcrumbs;
    }
}
