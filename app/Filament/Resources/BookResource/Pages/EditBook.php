<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }



         protected function getSavedNotificationTitle(): ?string
    {
        return  __('validation.book_updated');
    }


       protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
