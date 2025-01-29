<?php

namespace App\Filament\Resources\EsetupResource\Pages;

use App\Filament\Resources\EsetupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEsetup extends EditRecord
{
    protected static string $resource = EsetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
