<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterviewResource\Pages;
use App\Filament\Resources\InterviewResource\RelationManagers;
use App\Models\Interview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InterviewResource extends Resource
{
    protected static ?string $model = Interview::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


     public static function getNavigationGroup(): string
    {
        return __('validation.sidebar');
    }
      public static function getNavigationLabel(): string
    {
        return __('validation.interviews_student');
    }

    public static function getModelLabel(): string
    {
        return __('validation.interviews_student');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.interviews_student');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label(__('validation.interview_title'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('link')
                    ->label(__('validation.interview_link'))
                    ->maxLength(255),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label(__('validation.interview_image'))
                    ->disk('public')
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label(__('validation.interview_title')),


                Tables\Columns\TextColumn::make('link')
                    ->label(__('validation.interview_link'))
                    ->url(fn($record) => $record->link)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => 'Link')
                    ->color('info'),


                Tables\Columns\ImageColumn::make('image')
                ->label(__('validation.interview_image'))
                ,

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                 Tables\Actions\DeleteAction::make()
                ->successNotification(Notification::make()
                    ->title(__('validation.book_deleted'))
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInterviews::route('/'),
            'create' => Pages\CreateInterview::route('/create'),
            'edit' => Pages\EditInterview::route('/{record}/edit'),
        ];
    }
}
