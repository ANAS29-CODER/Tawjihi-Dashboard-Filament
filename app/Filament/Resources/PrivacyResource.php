<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrivacyResource\Pages;
use App\Filament\Resources\PrivacyResource\RelationManagers;
use App\Models\Privacy;
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

class PrivacyResource extends Resource
{
    protected static ?string $model = Privacy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


       public static function getNavigationLabel(): string
    {
        return __('validation.privacy_policies');
    }

    public static function getModelLabel(): string
    {
        return __('validation.privacy_policies');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.privacy_policies');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label(__('validation.privacy_policy_title'))
                    ->maxLength(255),

                RichEditor::make('privacy_text')
                    ->required()
                    ->label(__('validation.privacy_policy_content'))
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                      TextColumn::make('privacy_text')
                    ->label(__('validation.privacy_policy_content'))
                    ->html() // Allows HTML rendering
                    ->limit(70) // Optional: limits the displayed text length
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state; // Shows full text on hover
                    }),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                   Tables\Actions\DeleteAction::make()
                ->successNotification(Notification::make()
                    ->title(__('validation.privacy_policy_deleted'))
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
            'index' => Pages\ListPrivacies::route('/'),
            'create' => Pages\CreatePrivacy::route('/create'),
            'edit' => Pages\EditPrivacy::route('/{record}/edit'),
        ];
    }
}
