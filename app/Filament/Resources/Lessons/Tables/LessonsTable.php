<?php

namespace App\Filament\Resources\Lessons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class LessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->columns([
                TextInputColumn::make('order')
                    ->label('Order #')
                    ->rules(['required', 'numeric', 'min:0'])
                    ->sortable()
                    ->width('80px'),
                TextColumn::make('module.course.title')
                    ->label('Course')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->limit(25),
                TextColumn::make('module.title')
                    ->label('Module')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->limit(30),
                TextColumn::make('title')
                    ->label('Lesson Title')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'text' => 'info',
                        'pdf' => 'danger',
                        'quiz' => 'warning',
                        'video' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('attachment_path')
                    ->label('Study PDF')
                    ->formatStateUsing(fn ($state) => ! empty($state) ? '📄 PDF' : '—')
                    ->badge()
                    ->color(fn ($state) => ! empty($state) ? 'danger' : 'gray')
                    ->url(fn ($record) => ! empty($record->attachment_path) ? asset('storage/' . $record->attachment_path) : null, shouldOpenInNewTab: true),
                TextColumn::make('quiz_questions')
                    ->label('Practice Quiz')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' MCQs' : '0 MCQs')
                    ->badge()
                    ->color(fn ($state) => (is_array($state) && count($state) > 0) ? 'warning' : 'gray'),
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
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('course')
                    ->relationship('module.course', 'title')
                    ->label('Filter by Course')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('module_id')
                    ->relationship('module', 'title')
                    ->label('Filter by Module')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('type')
                    ->options([
                        'text' => 'Study Notes (Text)',
                        'pdf' => 'PDF Document',
                        'quiz' => 'Practice Quiz',
                        'video' => 'Video Lecture',
                    ]),
                TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
