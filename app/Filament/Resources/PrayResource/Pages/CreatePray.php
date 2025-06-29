<?php

namespace App\Filament\Resources\PrayResource\Pages;

use App\Filament\Resources\PrayResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePray extends CreateRecord
{
    protected static string $resource = PrayResource::class;


        protected function getCreatedNotificationTitle(): ?string
    {
        return  __('validation.prayer_created');
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
