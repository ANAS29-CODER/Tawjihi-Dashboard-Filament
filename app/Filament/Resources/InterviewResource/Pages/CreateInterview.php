<?php

namespace App\Filament\Resources\InterviewResource\Pages;

use App\Filament\Resources\InterviewResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInterview extends CreateRecord
{
    protected static string $resource = InterviewResource::class;


     protected function getCreatedNotificationTitle(): ?string
    {
        return  __('validation.interview_created');
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
