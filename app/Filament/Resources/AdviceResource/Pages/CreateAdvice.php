<?php

namespace App\Filament\Resources\AdviceResource\Pages;

use App\Filament\Resources\AdviceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdvice extends CreateRecord
{
    protected static string $resource = AdviceResource::class;



      protected function getCreatedNotificationTitle(): ?string
    {
        return  __('validation.advice_created');
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
