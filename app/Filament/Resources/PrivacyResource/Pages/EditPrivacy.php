<?php

namespace App\Filament\Resources\PrivacyResource\Pages;

use App\Filament\Resources\PrivacyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrivacy extends EditRecord
{
    protected static string $resource = PrivacyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function getSavedNotificationTitle(): ?string
    {
        return  __('validation.privacy_policy_updated');
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
