<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getNavigationLabel(): string
    {

        return __('validation.books');
    }

    public static function getModelLabel(): string
    {
        return __('validation.book');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.books');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('validation.book_name'))
                    ->maxLength(255),


                Select::make('subject_id')
                    ->label(__('validation.subject_name'))
                    ->relationship('subject', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('book_link')
                    ->maxLength(255)
                    ->label(__('validation.book_link')),

                Forms\Components\FileUpload::make('book_file')
                    ->label(__('validation.book_file'))
                    ->disk('public')
                    ->directory('books')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $livewire) {
                        return $file->getClientOriginalName();
                    }),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label(__('validation.book_image'))
                    ->disk('public'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('validation.book_name')),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label(__('validation.subject_name'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('book_link')
                    ->searchable()
                    ->url(fn($record) => $record->book_link)
                    ->label(__('validation.book_link'))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => 'File Link')
                    ->color('info'),


                TextColumn::make('book_file')
                    ->label(__('validation.book_file'))
                    ->url(fn($record) => Storage::disk('public')->url($record->book_file))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => 'File')
                    ->color('info'),

                Tables\Columns\ImageColumn::make('image')
                    ->label(__('validation.book_image'))
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
