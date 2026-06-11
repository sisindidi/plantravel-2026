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
    $items = $data['items_repeater'] ?? [];
    $firstRecord = null;

    foreach ($items as $item) {
        $packing = \App\Models\Packinglist::create([
            'trip_id' => $tripId,
            'item_name' => $item['item_name'],
            'is_checked' => $item['is_checked'] ?? false,
        ]);

        if (!$firstRecord) { $firstRecord = $packing; }
    }

    return $firstRecord ?? \App\Models\Packinglist::create(['trip_id' => $tripId, 'item_name' => 'Default', 'is_checked' => false]);
}
}