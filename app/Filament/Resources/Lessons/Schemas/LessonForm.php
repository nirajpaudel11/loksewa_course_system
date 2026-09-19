<?php

namespace App\Filament\Resources\Lessons\Schemas;

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

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lesson Information')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('module_id')
                                ->relationship('module', 'title')
                                ->label('Parent Module (e.g., GK & IQ 1st Paper, 2nd Paper)')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('chapter_id')
                                ->relationship('chapter', 'title')
                                ->label('Parent Chapter / Sub-section (Optional)')
                                ->searchable()
                                ->preload()
                                ->nullable(),
                            TextInput::make('title')
                                ->label('Lesson Title (e.g., History of Nepal, Geography)')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                            TextInput::make('slug')
                                ->required(),
                            Select::make('type')
                                ->label('Lesson Structure Type')
                                ->options([
                                    'text' => 'Study Notes & Theoretical Content',
                                    'pdf' => 'PDF Document Material',
                                    'quiz' => 'Dynamic MCQ Practice Quiz',
                                    'video' => 'Video Lecture',
                                ])
                                ->default('text')
                                ->live()
                                ->required(),
                            TextInput::make('duration_minutes')
                                ->label('Estimated Study Time (Minutes)')
                                ->required()
                                ->numeric()
                                ->default(15),
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
                    ]),

                Section::make('Study Notes & Theoretical Content')
                    ->description('Enter lesson notes, key definitions, legal frameworks, and syllabus points.')
                    ->schema([
                        Textarea::make('content')
                            ->label('Lesson Notes / Syllabus Text Content')
                            ->rows(10)
                            ->placeholder("१. विषयवस्तुको पृष्ठभूमि र ऐतिहासिक तथ्यहरू...\n२. मुख्य संवैधानिक तथा कानुनी व्यवस्थाहरू...\n३. परीक्षा तयारीका लागि ध्यान दिनुपर्ने बुँदाहरू...")
                            ->columnSpanFull(),
                    ]),

                Section::make('Attached Study PDF Document')
                    ->description('Upload dedicated PDF syllabus notes, handouts, or model question document.')
                    ->schema([
                        FileUpload::make('attachment_path')
                            ->label('Upload Attached PDF Document')
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
                            ->helperText('Upload official Loksewa syllabus notes or model question PDF (Max 100MB). Click the "X" icon to remove and replace with a new PDF.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Interactive Practice Quiz Builder (With Hints 💡)')
                    ->description('Add MCQ practice questions for this lesson. Students can test their knowledge and access clues/hints during practice.')
                    ->schema([
                        Repeater::make('quiz_questions')
                            ->label('Quiz Questions List')
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? 'New MCQ Question')
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
                                    ->label('💡 Question Hint / Clue (For Students)')
                                    ->placeholder('e.g., Think of the gas giant with the Great Red Spot or the king who issued Manaank...')
                                    ->helperText('Provide a subtle clue or conceptual hint to guide students without writing the direct answer.')
                                    ->columnSpanFull(),
                                Textarea::make('explanation')
                                    ->label('Detailed Loksewa Explanation & Legal Reference')
                                    ->rows(2)
                                    ->placeholder('e.g., Mandev I was the first historical king of Nepal who issued Manaank coins in 521 BS...')
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

                Section::make('Video Lecture Media (Optional)')
                    ->collapsed()
                    ->schema([
                        TextInput::make('video_url')
                            ->label('Streaming URL (YouTube / Vimeo / Cloudflare)')
                            ->url()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
