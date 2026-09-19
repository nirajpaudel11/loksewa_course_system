<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('course-thumbnails')
                    ->maxSize(2048)
                    ->columnSpanFull(),
                FileUpload::make('syllabus_pdf')
                    ->label('Official Course Syllabus PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('courses/syllabus')
                    ->maxSize(102400)
                    ->openable()
                    ->downloadable()
                    ->deletable(true)
                    ->fetchFileInformation(false)
                    ->preventFilePathTampering(false)
                    ->deleteUploadedFileUsing(function ($file) {
                        if (! empty($file) && is_string($file)) {
                            @Storage::disk('public')->delete($file);
                        }
                    })
                    ->helperText('Upload the official Loksewa PSC syllabus PDF for this preparation course (Max 100MB). Click the "X" icon to remove and replace with a new PDF.')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->default(true),
            ]);
    }
}
