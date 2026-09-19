<?php

namespace App\Filament\Resources\Modules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ModulesTable
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
                    ->width('90px'),
                TextColumn::make('course.title')
                    ->label('Course')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('title')
                    ->label('Module Title')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('lessons_count')
                    ->counts('lessons')
                    ->label('Lessons')
                    ->badge()
                    ->color('success'),
                TextColumn::make('pdf_file')
                    ->label('Study PDF')
                    ->formatStateUsing(fn ($state) => ! empty($state) ? '📄 PDF' : '—')
                    ->badge()
                    ->color(fn ($state) => ! empty($state) ? 'info' : 'gray')
                    ->url(fn ($record) => ! empty($record->pdf_file) ? asset('storage/' . $record->pdf_file) : null, shouldOpenInNewTab: true),
                TextColumn::make('quiz_questions')
                    ->label('Quiz Qs')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' MCQs' : '0 MCQs')
                    ->badge()
                    ->color(fn ($state) => (is_array($state) && count($state) > 0) ? 'warning' : 'gray'),
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
                SelectFilter::make('course_id')
                    ->relationship('course', 'title')
                    ->label('Filter by Course')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_published')
                    ->label('Published Status'),
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
