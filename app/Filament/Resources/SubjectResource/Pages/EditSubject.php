<?php

namespace App\Filament\Resources\SubjectResource\Pages;

use App\Filament\Resources\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubject extends EditRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


         protected function getSavedNotificationTitle(): ?string
    {
        return  __('validation.subject_updated');
    }


       protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
