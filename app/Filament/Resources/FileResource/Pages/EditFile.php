<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFile extends EditRecord
{
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


     protected function getSavedNotificationTitle(): ?string
    {
        return  __('validation.file_updated');
    }


       protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
