<?php

namespace App\Filament\Resources\BarResource\Pages;

use App\Filament\Resources\BarResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBar extends ViewRecord
{
    protected static string $resource = BarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
