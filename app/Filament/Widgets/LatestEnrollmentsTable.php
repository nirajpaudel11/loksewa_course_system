<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestEnrollmentsTable extends TableWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest Enrollments')
            ->query(
                Enrollment::query()
                    ->with(['user', 'course'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student')
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('course.title')
                    ->label('Course')
                    ->icon('heroicon-o-academic-cap')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'active' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->suffix('%')
                    ->color(fn (int $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 40 => 'warning',
                        default => 'danger',
                    })
                    ->weight('bold'),

                TextColumn::make('created_at')
                    ->label('Enrolled')
                    ->since()
                    ->sortable()
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}
