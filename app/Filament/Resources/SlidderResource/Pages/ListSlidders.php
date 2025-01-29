<?php

namespace App\Filament\Resources\SlidderResource\Pages;

use App\Filament\Resources\SlidderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlidders extends ListRecords
{
    protected static string $resource = SlidderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
