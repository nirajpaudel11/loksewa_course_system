<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('remove_syllabus_pdf')
                ->label('Remove Syllabus PDF')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Remove Course Syllabus PDF')
                ->modalDescription('Are you sure you want to remove the syllabus PDF from this course?')
                ->visible(fn () => ! empty($this->getRecord()->syllabus_pdf))
                ->action(function () {
                    $record = $this->getRecord();
                    if ($record->syllabus_pdf) {
                        @Storage::disk('public')->delete($record->syllabus_pdf);
                        $record->update(['syllabus_pdf' => null]);
                        $this->fillForm();
                        Notification::make()
                            ->title('Syllabus PDF Removed Successfully')
                            ->success()
                            ->send();
                    }
                }),
            DeleteAction::make(),
        ];
    }
}
