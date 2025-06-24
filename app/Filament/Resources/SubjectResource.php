<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\RelationManagers\SubjectsRelationManager;
use App\Filament\Resources\BranchResource\RelationManagers\SubjetcRelationManager;
use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationLabel(): string
    {
        return __('validation.subjects');
    }

    public static function getModelLabel(): string
    {
        return __('validation.subject');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.subjects');
    }
    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('validation.subject_name'))->searchable(),

                Tables\Columns\TextColumn::make('branch.name')
                    ->label(__('validation.branch'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image')->label(__('validation.subject_image')),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(20)
                    ->wrap(),



            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [

    


        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
