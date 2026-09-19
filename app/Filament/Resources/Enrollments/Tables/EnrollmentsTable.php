<?php

namespace App\Filament\Resources\Enrollments\Tables;

use App\Models\Enrollment;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student')
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->color('gray'),
                TextColumn::make('course.title')
                    ->label('Enrolled Course')
                    ->icon('heroicon-o-academic-cap')
                    ->searchable()
                    ->limit(35)
                    ->sortable(),
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
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 40 => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Requested At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Approval',
                        'active' => 'Active / Verified',
                        'completed' => 'Completed',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->recordActions([
                Action::make('verify')
                    ->label('Approve')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->visible(fn (Enrollment $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Student Enrollment')
                    ->modalDescription('Approving this enrollment will immediately grant the student access to course lessons, quizzes, and downloadable PDFs.')
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
                    ->modalDescription('Rejecting will lock course content for this student.')
                    ->action(function (Enrollment $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('Enrollment Rejected')
                            ->body("Enrollment request for {$record->user->name} was rejected.")
                            ->warning()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('approve_bulk')
                        ->label('Approve Selected')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'active']);
                            Notification::make()
                                ->title('Bulk Approval Completed')
                                ->body('Selected enrollments have been verified.')
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
