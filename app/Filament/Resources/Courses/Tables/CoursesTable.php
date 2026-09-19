<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'beginner' => 'info',
                        'intermediate' => 'warning',
                        'advanced' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('modules_count')
                    ->counts('modules')
                    ->label('Modules')
                    ->badge()
                    ->color('success'),
                TextColumn::make('syllabus_pdf')
                    ->label('Syllabus PDF')
                    ->formatStateUsing(fn ($state) => ! empty($state) ? '📄 ' . basename($state) : '—')
                    ->badge()
                    ->color(fn ($state) => ! empty($state) ? 'primary' : 'gray')
                    ->url(fn ($record) => ! empty($record->syllabus_pdf) ? asset('storage/' . $record->syllabus_pdf) : null, shouldOpenInNewTab: true)
                    ->toggleable(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('trending_score')
                    ->label('Trending Score')
                    ->numeric(2)
                    ->badge()
                    ->color('warning')
                    ->sortable(),
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
                //
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
