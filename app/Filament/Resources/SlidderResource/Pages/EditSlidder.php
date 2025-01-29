<?php

namespace App\Filament\Resources\SlidderResource\Pages;

use App\Filament\Resources\SlidderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlidder extends EditRecord
{
    protected static string $resource = SlidderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
