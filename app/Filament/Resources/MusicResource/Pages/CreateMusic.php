<?php

namespace App\Filament\Resources\MusicResource\Pages;

use App\Filament\Resources\MusicResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class CreateMusic extends CreateRecord
{
    protected static string $resource = MusicResource::class;




    protected function getCreatedNotificationTitle(): ?string
    {
        return  __('validation.music_created');
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }



    protected function beforeCreate(): void
    {
        $data = $this->data;

        if (empty($data['music_link']) && empty($data['music_file'])) {
            Notification::make()
                ->title('You must provide either a music link or file')
                ->danger()
                ->send();

            $this->halt(); // Prevents record creation
        }
    }
   
}
