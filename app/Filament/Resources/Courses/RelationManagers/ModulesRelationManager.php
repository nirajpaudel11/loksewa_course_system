<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use App\Filament\Resources\Modules\ModuleResource;
use App\Models\Module;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Module Title (e.g., GK & IQ 1st Paper)')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->label('Module Summary')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_published')
                    ->default(true)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->columns([
                TextInputColumn::make('order')
                    ->label('Order #')
                    ->rules(['required', 'numeric', 'min:0'])
                    ->sortable()
                    ->width('90px'),
                TextColumn::make('title')
                    ->label('Module Title')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('lessons_count')
                    ->counts('lessons')
                    ->label('Lessons')
                    ->badge()
                    ->color('success'),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Module to Course'),
            ])
            ->recordActions([
                Action::make('manageLessons')
                    ->label('Manage Lessons')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->color('primary')
                    ->url(fn (Module $record): string => ModuleResource::getUrl('edit', ['record' => $record])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
