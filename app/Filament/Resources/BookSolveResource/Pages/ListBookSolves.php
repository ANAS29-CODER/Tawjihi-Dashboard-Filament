<?php

namespace App\Filament\Resources\BookSolveResource\Pages;

use App\Filament\Resources\BookSolveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookSolves extends ListRecords
{
    protected static string $resource = BookSolveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
