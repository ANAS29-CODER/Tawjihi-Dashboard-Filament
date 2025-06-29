<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusicResource\Pages;
use App\Filament\Resources\MusicResource\RelationManagers;
use App\Models\Music;
use Closure;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MusicResource extends Resource
{
    protected static ?string $model = Music::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    public static function getNavigationGroup(): string
    {
        return __('validation.sidebar');
    }


    public static function getNavigationLabel(): string
    {
        return __('validation.musics');
    }

    public static function getModelLabel(): string
    {
        return __('validation.musics');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.musics');
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('validation.music_name'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('music_link')
                    ->label(__('validation.music_link'))
                    ->maxLength(255)
                    ->reactive()
                    ->url()
                    ->nullable(),

                FileUpload::make('music_file')
                    ->label(__('validation.music_file'))
                    ->disk('public')
                    ->acceptedFileTypes([
                        'audio/mpeg',
                        'audio/mp3',
                    ])
                    ->rules([
                        'file',
                        'mimetypes:audio/mpeg,audio/mp3',
                    ])
                    ->directory('musics')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $livewire) {
                        return $file->getClientOriginalName();
                    })
                    ->reactive()
                    ->nullable(),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('validation.music_name')),

                Tables\Columns\TextColumn::make('music_link')
                    ->label(__('validation.music_link')),

                ViewColumn::make('music_file')
                    ->label(__('validation.music_link'))
                    ->view('components.audio-player'),



            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->title(__('validation.music_deleted'))
                            ->success()
                    )
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
            'index' => Pages\ListMusic::route('/'),
            'create' => Pages\CreateMusic::route('/create'),
            'edit' => Pages\EditMusic::route('/{record}/edit'),
        ];
    }
}
