<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFile extends CreateRecord
{
    protected static string $resource = FileResource::class;




    protected function getCreatedNotificationTitle(): ?string
    {
        return  __('validation.file_created');
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
