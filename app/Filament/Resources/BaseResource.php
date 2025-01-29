<?php

namespace App\Filament\Resources;
use Filament\Resources\Resource;

abstract class BaseResource extends Resource
{
    
    public static function getPages(): array
    {
        return [
           'index' => static::getListPageClass()::route('/'),
          
        ];
    }
}
