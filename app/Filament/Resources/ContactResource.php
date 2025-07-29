<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?int $navigationSort = 11;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';


    public static function getNavigationLabel(): string
    {
        return __('validation.contact_us');
    }

    public static function getModelLabel(): string
    {
        return __('validation.contact_us');
    }

    public static function getPluralModelLabel(): string
    {
        return __('validation.contact_us');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('Email')
                    ->maxLength(255),

                Forms\Components\TextInput::make('whatsapp_link')
                    ->maxLength(255)
                    ->label('WhatsApp'),

                Forms\Components\TextInput::make('facbook_link')
                    ->maxLength(255)
                    ->label('Facebook'),

                Forms\Components\TextInput::make('instagram_link')
                    ->maxLength(255)
                    ->label('Instagram'),

                Forms\Components\TextInput::make('telegarm_link')
                    ->maxLength(255)
                    ->label('Telegram'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),

                TextColumn::make('whatsapp_link')
                    ->formatStateUsing(fn() => '')
                    ->label('WhatsApp')
                    ->view('components.contacts.whatsapp-link')

                    ,

                TextColumn::make('facbook_link')
                    ->formatStateUsing(fn() => '')
                    ->label('Facebook')
                    ->view('components.contacts.facebook-link'),

                TextColumn::make('instagram_link')
                    ->formatStateUsing(fn() => '')
                    ->label('Instagram')
                    ->view('components.contacts.instagram-link'),

                TextColumn::make('telegarm_link')
                    ->formatStateUsing(fn() => '')
                    ->label('Telegram')
                    ->view('components.contacts.telegram-link'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
