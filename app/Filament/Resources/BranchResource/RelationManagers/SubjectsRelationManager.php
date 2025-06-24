<?php

namespace App\Filament\Resources\BranchResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'subjects';

       public static function getTitle(Model $ownerRecord, string $pageClass): string
       {
        return __('validation.subjects');
       }


    public static function getModelLabel(): string
    {
        return __('validation.subject');
    }

    public static function getpluralModelLabel(): string
    {
        return __('validation.Subjects');
    }

    public function form(Form $form): Form
    {
        return $form
          ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('validation.subject_name'))
                    ->maxLength(255),

                Select::make('branch_id')
                    ->label(__('validation.branch'))
                    ->relationship('branch', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\FileUpload::make('image')
                    ->label(__('validation.subject_image'))
                    ->disk('public')

                    ->image(),

                RichEditor::make('description')
                    ->label(__('validation.description')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->successNotification(
                        Notification::make()
                        ->title(__('validation.subject_updated'))
                        ->success()
                    ),
                Tables\Actions\DeleteAction::make()
                ->successNotification(
                        Notification::make()
                            ->title(__('validation.subject_deleted'))
                            ->success()
                ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
