<?php

namespace App\Filament\Resources\Modules\Pages;

use App\Filament\Resources\Modules\ModuleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateModule extends CreateRecord
{
    protected static string $resource = ModuleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
}
