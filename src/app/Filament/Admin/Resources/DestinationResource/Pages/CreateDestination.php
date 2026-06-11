<?php

namespace App\Filament\Admin\Resources\DestinationResource\Pages;

use App\Filament\Admin\Resources\DestinationResource;
use App\Models\Destination;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDestination extends CreateRecord
{
    protected static string $resource = DestinationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $tripId = $data['trip_id'];
        $destinations = $data['destinations_repeater'] ?? [];
        $firstRecord = null;

        foreach ($destinations as $dest) {
            // BERSIH: Membuang key visit_date dari query insert database flat lu
            $destination = Destination::create([
                'trip_id' => $tripId,
                'name' => $dest['name'],
            ]);

            if (!$firstRecord) {
                $firstRecord = $destination;
            }
        }

        return $firstRecord ?? Destination::create([
            'trip_id' => $tripId,
            'name' => 'Belum Ditentukan',
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}