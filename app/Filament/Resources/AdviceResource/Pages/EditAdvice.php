<?php

namespace App\Filament\Resources\AdviceResource\Pages;

use App\Filament\Resources\AdviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvice extends EditRecord
{
    protected static string $resource = AdviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }





    protected function getSavedNotificationTitle(): ?string
    {
        return  __('validation.advice_updated');
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
