<?php

namespace App\Filament\Resources\CasteResource\Pages;

use App\Filament\Resources\CasteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaste extends EditRecord
{
    protected static string $resource = CasteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
