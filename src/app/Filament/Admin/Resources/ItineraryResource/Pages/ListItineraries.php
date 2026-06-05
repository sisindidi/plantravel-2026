<?php

namespace App\Filament\Admin\Resources\ItineraryResource\Pages;

use App\Filament\Admin\Resources\ItineraryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItineraries extends ListRecords
{
    protected static string $resource = ItineraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
