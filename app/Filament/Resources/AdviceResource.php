<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdviceResource\Pages;
use App\Filament\Resources\AdviceResource\RelationManagers;
use App\Models\Advice;
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

class AdviceResource extends Resource
{

    protected static ?string $model = Advice::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';


    protected static ?int $navigationSort = 9;

    public static function getNavigationGroup(): string
    {
        return __('validation.sidebar');
    }

    public static function getNavigationLabel(): string
    {

        return __('validation.public_advices');
    }

    public static function getModelLabel(): string
    {
        return __('validation.public_advices');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.public_advices');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label(__('validation.advice_title'))
                    ->maxLength(255),



                Select::make('subject_id')
                    ->label(__('validation.subject_name'))
                    ->relationship('subject', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                RichEditor::make('advice_text')
                    ->required()
                    ->label(__('validation.advice_text')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label(__('validation.advice_title')),


                Tables\Columns\TextColumn::make('advice_text')
                    ->label(__('validation.advice_text'))
                    ->html() // Allows HTML rendering
                    ->limit(80) // Optional: limits the displayed text length
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state; // Shows full text on hover
                    }),




                Tables\Columns\TextColumn::make('subject.name')
                    ->label(__('validation.subject_name'))
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->title(__('validation.advice_deleted'))
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
            'index' => Pages\ListAdvice::route('/'),
            'create' => Pages\CreateAdvice::route('/create'),
            'edit' => Pages\EditAdvice::route('/{record}/edit'),
        ];
    }
}
