<?php

namespace App\Filament\Resources\BookSolveResource\Pages;

use App\Filament\Resources\BookSolveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookSolve extends CreateRecord
{
    protected static string $resource = BookSolveResource::class;

         protected function getCreatedNotificationTitle(): ?string
    {
        return  __('validation.solve_file_created');
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
