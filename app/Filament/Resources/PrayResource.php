<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrayResource\Pages;
use App\Filament\Resources\PrayResource\RelationManagers;
use App\Models\Pray;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PrayResource extends Resource
{
    protected static ?string $model = Pray::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getNavigationLabel(): string
    {
        return __('validation.prayers');
    }

    public static function getModelLabel(): string
    {
        return __('validation.prayers');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.prayers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('pray_text')
                    ->required()
                    ->label(__('validation.prayer_text'))
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('pray_image')
                    ->label(__('validation.prayer_image'))
                    ->disk('public')
                    ->image()
                    ->directory('prays')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $livewire) {
                        return $file->getClientOriginalName();
                    })
                    ->rules(['image', 'max:2048']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('pray_text')
                    ->label(__('validation.prayer_text'))
                    ->html() // Allows HTML rendering
                    ->limit(50) // Optional: limits the displayed text length
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state; // Shows full text on hover
                    }),

                Tables\Columns\ImageColumn::make('pray_image')
                    ->label(__('validation.prayer_image')),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->successNotification(
                    Notification::make()
                    ->title(__('validation.prayer_deleted'))
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
            'index' => Pages\ListPrays::route('/'),
            'create' => Pages\CreatePray::route('/create'),
            'edit' => Pages\EditPray::route('/{record}/edit'),
        ];
    }
}
