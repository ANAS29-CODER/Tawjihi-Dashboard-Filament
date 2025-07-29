<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ButtonResource\Pages;
use App\Filament\Resources\ButtonResource\RelationManagers;
use App\Models\Button;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ButtonResource extends Resource
{
    protected static ?string $model = Button::class;

    protected static ?int $navigationSort = 8;


protected static ?string $navigationIcon = 'heroicon-o-arrows-pointing-in';

    public static function getNavigationLabel(): string
    {
        return __('validation.file_buttons');
    }

    public static function getModelLabel(): string
    {
        return __('validation.file_buttons');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.file_buttons');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('validation.button_name'))
                    ->required()
                    ->maxLength(255),


                Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->label(__('validation.select_subject'))
                    ->required()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name . ' - ' . ($record->branch->name ?? '')),



                Select::make('selected_sections')
                    ->label('Selected Sections')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->options(Section::pluck('name', 'name')->toArray()) // use name => name if you want names
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->label(__('validation.button_name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label(__('validation.subject_name'))
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('selected_sections')
                    ->label(__('validation.selected_sections'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->title(__('validation.solve_file_deleted'))
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
            'index' => Pages\ListButtons::route('/'),
            'create' => Pages\CreateButton::route('/create'),
            'edit' => Pages\EditButton::route('/{record}/edit'),
        ];
    }
}
