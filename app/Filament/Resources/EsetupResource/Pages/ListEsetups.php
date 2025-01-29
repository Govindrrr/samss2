<?php

namespace App\Filament\Resources\EsetupResource\Pages;

use App\Filament\Resources\EsetupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEsetups extends ListRecords
{
    protected static string $resource = EsetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
