<?php

namespace App\Filament\Resources\Modules\RelationManagers;

use App\Filament\Resources\Lessons\LessonResource;
use App\Filament\Resources\Lessons\Schemas\LessonForm;
use App\Models\Lesson;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Schema $schema): Schema
    {
        return LessonForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->columns([
                TextInputColumn::make('order')
                    ->label('Order #')
                    ->rules(['required', 'numeric', 'min:0'])
                    ->sortable()
                    ->width('90px'),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->numeric()
                    ->suffix(' min')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Lesson to Module')
                    ->mutateFormDataUsing(function (array $data): array {
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
                    }),
            ])
            ->recordActions([
                Action::make('openLesson')
                    ->label('Edit Full')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->color('primary')
                    ->url(fn (Lesson $record): string => LessonResource::getUrl('edit', ['record' => $record])),
                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
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
                    })
                    ->mutateFormDataUsing(function (array $data): array {
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
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
