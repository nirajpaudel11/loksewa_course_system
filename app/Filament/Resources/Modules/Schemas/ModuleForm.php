<?php

namespace App\Filament\Resources\Modules\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Module Core Information')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('course_id')
                                ->relationship('course', 'title')
                                ->label('Parent Course (e.g., Kharidar, Nayab Subba)')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('title')
                                ->label('Module Title (e.g., GK & IQ 1st Paper, 2nd Paper)')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                            TextInput::make('slug')
                                ->required(),
                            TextInput::make('order')
                                ->label('Display Order')
                                ->required()
                                ->numeric()
                                ->default(0),
                            Toggle::make('is_published')
                                ->label('Published')
                                ->default(true)
                                ->required(),
                        ]),
                        Textarea::make('description')
                            ->label('Module Brief Overview')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Key Points to Focus On (Admin Space)')
                    ->description('Write high-yield exam takeaways, memory mnemonics, formulas, and critical Loksewa focus areas for this module.')
                    ->schema([
                        Textarea::make('key_points')
                            ->label('Key Points & Exam Focus Areas')
                            ->rows(6)
                            ->placeholder("• Focus heavily on Articles 16 to 48 (Fundamental Rights)\n• Memorize appointment procedures and qualification criteria\n• Common exam traps in recent PSC papers")
                            ->helperText('Use bullet points (•) for clean formatting on the student learning page.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Detailed Module Study Notes')
                    ->description('Comprehensive theoretical notes, syllabus coverage, and analytical overview for this module.')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Theoretical Notes & Syllabus Details')
                            ->rows(10)
                            ->placeholder('Enter detailed module study notes, concept explanations, and syllabus coverage...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Attached Module Study PDF / Syllabus')
                    ->description('Upload official module PDF notes, syllabus chapter reference, or model questions.')
                    ->schema([
                        FileUpload::make('pdf_file')
                            ->label('Upload Module PDF Document')
                            ->disk('public')
                            ->directory('lessons/pdfs')
                            ->acceptedFileTypes(['application/pdf'])
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
                            ->helperText('Upload official module syllabus PDF or study material (Max 100MB). Click the "X" icon to remove and replace.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Module Practice Quiz Builder (With Hints)')
                    ->description('Create MCQ practice questions for this module. Each question supports 4 options, a correct choice, a helpful student hint 💡, and a detailed explanation.')
                    ->schema([
                        Repeater::make('quiz_questions')
                            ->label('Quiz Questions List')
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? 'New Quiz Question')
                            ->schema([
                                TextInput::make('question')
                                    ->label('Question Prompt / Text')
                                    ->required()
                                    ->columnSpanFull(),
                                Grid::make(2)->schema([
                                    TextInput::make('option_0')
                                        ->label('Option A (Choice 1)')
                                        ->required(),
                                    TextInput::make('option_1')
                                        ->label('Option B (Choice 2)')
                                        ->required(),
                                    TextInput::make('option_2')
                                        ->label('Option C (Choice 3)')
                                        ->required(),
                                    TextInput::make('option_3')
                                        ->label('Option D (Choice 4)')
                                        ->required(),
                                ]),
                                Select::make('answer')
                                    ->label('Correct Option')
                                    ->options([
                                        0 => 'Option A (Choice 1)',
                                        1 => 'Option B (Choice 2)',
                                        2 => 'Option C (Choice 3)',
                                        3 => 'Option D (Choice 4)',
                                    ])
                                    ->default(0)
                                    ->required(),
                                TextInput::make('hint')
                                    ->label('💡 Question Hint (Clue for Students)')
                                    ->placeholder('e.g., Think of the constitutional body created under Part 21...')
                                    ->helperText('Students can click "Need a Hint? 💡" during the quiz to view this clue.')
                                    ->columnSpanFull(),
                                Textarea::make('explanation')
                                    ->label('Detailed Loksewa Explanation & Legal Reference')
                                    ->rows(2)
                                    ->placeholder('e.g., According to Nepal Constitution Article 242, the Commission consists of a Chairman and 4 members...')
                                    ->columnSpanFull(),
                            ])
                            ->default([
                                [
                                    'question' => '',
                                    'option_0' => '',
                                    'option_1' => '',
                                    'option_2' => '',
                                    'option_3' => '',
                                    'answer' => 0,
                                    'hint' => '',
                                    'explanation' => '',
                                ],
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
