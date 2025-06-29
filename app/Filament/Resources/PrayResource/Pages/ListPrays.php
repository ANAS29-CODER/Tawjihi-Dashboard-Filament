<?php

namespace App\Filament\Resources\PrayResource\Pages;

use App\Filament\Resources\PrayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrays extends ListRecords
{
    protected static string $resource = PrayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
