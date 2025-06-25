<?php

namespace App\Filament\Resources\ButtonResource\Pages;

use App\Filament\Resources\ButtonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateButton extends CreateRecord
{
    protected static string $resource = ButtonResource::class;



    protected function getCreatedNotificationTitle(): ?string
    {
        return  __('validation.file_button_created');
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }



}
