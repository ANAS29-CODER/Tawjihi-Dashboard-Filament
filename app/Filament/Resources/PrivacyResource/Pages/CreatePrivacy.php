<?php

namespace App\Filament\Resources\PrivacyResource\Pages;

use App\Filament\Resources\PrivacyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePrivacy extends CreateRecord
{
    protected static string $resource = PrivacyResource::class;



        protected function getCreatedNotificationTitle(): ?string
    {
        return  __('validation.privacy_policy_created');
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
