<?php

namespace App\Filament\Resources\BookSolveResource\Pages;

use App\Filament\Resources\BookSolveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookSolve extends EditRecord
{
    protected static string $resource = BookSolveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


        protected function getSavedNotificationTitle(): ?string
    {
        return  __('validation.solve_file_updated');
    }


       protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
