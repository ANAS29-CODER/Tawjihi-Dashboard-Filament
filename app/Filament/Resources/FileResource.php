<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
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
use Illuminate\Support\Facades\Storage;

class FileResource extends Resource
{
    protected static ?string $model = File::class;
    protected static ?int $navigationSort = 7;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationLabel(): string
    {
        return __('validation.files');
    }

    public static function getModelLabel(): string
    {
        return __('validation.files');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.files');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('validation.file_name'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('file_link')
                    ->maxLength(255)
                    ->label(__('validation.file_link')),

                Select::make('subject_id')
                    ->label(__('validation.file_subject'))
                    ->relationship('subject', 'name', fn($query) => $query->orderBy('name'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name . ' - ' . ($record->branch->name ?? '')),

                Select::make('section_id')
                    ->label(__('validation.file_section'))
                    ->relationship('section', 'name', fn($query) => $query->orderBy('name'))
                    ->required()
                    ->searchable()
                    ->preload(),

                FileUpload::make('file')
                    ->label(__('validation.file_path'))
                    ->disk('public')
                    ->directory('files')
                    ->getUploadedFileNameForStorageUsing(function ($file, $livewire) {
                        return $file->getClientOriginalName();
                    }),

                Forms\Components\FileUpload::make('image')
                    ->label(__('validation.file_image'))
                    ->disk('public')
                    ->directory('files/images')
                    ->getUploadedFileNameForStorageUsing(function ($file, $livewire) {
                        return $file->getClientOriginalName();
                    })
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('validation.file_name'))
                    ->searchable(),


                Tables\Columns\TextColumn::make('subject.name')
                    ->label(__('validation.file_subject'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('section.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('file_link')
                    ->label(__('validation.file_link'))
                    ->url(fn($record) => $record->file_link)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => __('validation.file_link'))
                    ->color('info'),

                Tables\Columns\TextColumn::make('file')
                    ->label(__('validation.file_path'))
                    ->url(fn($record) => Storage::disk('public')->url($record->file))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => 'Download')
                    ->color('info'),

                Tables\Columns\ImageColumn::make('image')
                    ->label(__('validation.file_image')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->title(__('validation.file_deleted'))
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
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}
