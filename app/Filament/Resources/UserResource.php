<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // write the users in single and plural in lang arabic
    protected static ?string $navigationLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $modelLabel = null;

    //write the functions that but the users in the navigation depend on the language system
    public static function getNavigationLabel(): string
    {
        return __('validation.users');
    }

    public static function getModelLabel(): string
    {
        return __('validation.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('validation.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__('validation.forms.email'))
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'users', column: 'email', ignorable: fn(?User $record) => $record),
                Forms\Components\TextInput::make('phone')
                    ->label(__('validation.forms.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(15),

                Forms\Components\TextInput::make('password')
                    ->label(__('validation.forms.password'))
                    ->translateLabel()
                    ->password()
                    ->required()
                    ->hidden(fn(string $operation): bool => $operation === 'edit')
                    ->visible(fn(string $operation): bool => $operation === 'create')
                    ->maxLength(255),
                     Forms\Components\FileUpload::make('image')
                    ->label(__('validation.forms.image'))
                    ->image()
                    ->disk('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            //add title
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->label(__('validation.forms.name')),
                Tables\Columns\TextColumn::make('email')
                ->label(__('validation.forms.email'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')->label(__('validation.forms.image')),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('validation.forms.phone'))
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
               \Filament\Tables\Actions\EditAction::make()
                     ->successRedirectUrl(UserResource::getUrl('index'))
                     ->successNotificationTitle(__('validation.user_updated')),
                     \Filament\Tables\Actions\DeleteAction::make()
                     ->successNotificationTitle(__('validation.user_deleted')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
