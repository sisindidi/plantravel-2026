<?php

namespace App\Filament\Admin\Resources\PackinglistResource\Pages;

use App\Filament\Admin\Resources\PackinglistResource;
use App\Models\Packinglist;
use Filament\Resources\Pages\CreateRecord;

class CreatePackinglists extends CreateRecord
{
    protected static string $resource = PackinglistResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $tripId = $data['trip_id'];
        $items = $data['packing_details'];

        foreach ($items as $item) {
            Packinglist::create([
                'trip_id'    => $tripId,
                'item_name'  => $item['item_name'],
                'is_checked' => $item['is_checked'] ?? false,
            ]);
        }

        // Return record pertama sebagai referensi
        return Packinglist::where('trip_id', $tripId)->latest()->first();
    }
}