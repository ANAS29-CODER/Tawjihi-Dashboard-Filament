<?php

namespace App\Filament\Resources\MusicResource\Pages;

use App\Filament\Resources\MusicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMusic extends EditRecord
{
    protected static string $resource = MusicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }



    protected function getSavedNotificationTitle(): ?string
    {
        return  __('validation.music_updated');
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }





    public static function beforeUpdate(Model $record, array $data): array
    {
        static::validateMusicInput($data);
        return $data;
    }

    public static function beforeCreate(array $data): array
    {
        static::validateMusicInput($data);
        return $data;
    }

    protected static function validateMusicInput(array $data): void
    {
        if (empty($data['music_link']) && empty($data['music_file'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'music_link' => __('validation.at_least_one_music'),
                'music_file' => __('validation.at_least_one_music'),
            ]);
        }
    }
}
