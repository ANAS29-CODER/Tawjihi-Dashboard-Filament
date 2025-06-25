<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookSolveResource\Pages;
use App\Filament\Resources\BookSolveResource\RelationManagers;
use App\Models\BookSolve;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BookSolveResource extends Resource
{
    protected static ?string $model = BookSolve::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getNavigationLabel(): string
    {
        return __('validation.solves');
    }

    public static function getModelLabel(): string
    {
        return __('validation.solves');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.solves');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->label(__('validation.solve_name'))
                    ->required()
                    ->maxLength(255),

                Select::make('subject_id')
                    ->label(__('validation.subject_name'))
                    ->relationship('subject', 'name', fn ($query) => $query->orderBy('name'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name . ' - ' . ($record->branch->name ?? '')),

                Forms\Components\TextInput::make('book_link')
                    ->label(__('validation.solve_link')),

                FileUpload::make('book_file')
                    ->label(__('validation.solve_file'))
                    ->disk('public')
                    ->directory('solves')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $livewire) {
                        return $file->getClientOriginalName();
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->label(__('validation.solve_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label(__('validation.subject_name'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('book_link')
                    ->label(__('validation.solve_link'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('book_file')
                    ->label(__('validation.solve_file'))
                    ->url(fn(BookSolve $record): ?string => $record->book_file ?
                        asset('storage/' . $record->book_file) : null)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => 'Solve')
                    ->color('info'),



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
            'index' => Pages\ListBookSolves::route('/'),
            'create' => Pages\CreateBookSolve::route('/create'),
            'edit' => Pages\EditBookSolve::route('/{record}/edit'),
        ];
    }
}
