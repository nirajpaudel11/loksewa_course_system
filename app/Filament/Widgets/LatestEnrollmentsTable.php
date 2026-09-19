<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
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
            ->heading('Student Enrollments & Approvals')
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
                    ->weight('bold'),

                TextColumn::make('course.title')
                    ->label('Course')
                    ->icon('heroicon-o-academic-cap')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'active' => 'success',
                        'completed' => 'info',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending Approval ⏳',
                        'active' => 'Active / Verified ✅',
                        'completed' => 'Completed 🎉',
                        'rejected' => 'Rejected ❌',
                        default => ucfirst($state),
                    }),

                TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->suffix('%')
                    ->color(fn (int $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 40 => 'warning',
                        default => 'gray',
                    })
                    ->weight('bold'),

                TextColumn::make('created_at')
                    ->label('Enrolled')
                    ->since()
                    ->sortable()
                    ->color('gray'),
            ])
            ->recordActions([
                Action::make('verify')
                    ->label('Approve')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->visible(fn (Enrollment $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Student Enrollment')
                    ->modalDescription('Approving this enrollment will immediately unlock course content for the student.')
                    ->action(function (Enrollment $record) {
                        $record->update(['status' => 'active']);
                        Notification::make()
                            ->title('Enrollment Approved')
                            ->body("{$record->user->name} now has active access to {$record->course->title}.")
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->visible(fn (Enrollment $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Student Enrollment')
                    ->action(function (Enrollment $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('Enrollment Rejected')
                            ->body("Enrollment for {$record->user->name} was rejected.")
                            ->warning()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}
