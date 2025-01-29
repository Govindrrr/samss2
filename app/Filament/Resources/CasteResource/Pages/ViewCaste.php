<?php

namespace App\Filament\Resources\CasteResource\Pages;

use App\Filament\Resources\CasteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCaste extends ViewRecord
{
    protected static string $resource = CasteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
