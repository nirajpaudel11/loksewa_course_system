<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->disabled(),
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->required()
                    ->disabled(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending Verification ⏳',
                        'active' => 'Active / Verified ✅',
                        'completed' => 'Completed 🎉',
                        'rejected' => 'Rejected ❌',
                    ])
                    ->required(),
                TextInput::make('progress_percentage')
                    ->numeric()
                    ->suffix('%')
                    ->default(0),
            ]);
    }
}
