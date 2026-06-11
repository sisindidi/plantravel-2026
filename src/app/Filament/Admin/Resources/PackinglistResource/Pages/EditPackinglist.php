<?php

namespace App\Filament\Admin\Resources\PackinglistResource\Pages;

use App\Filament\Admin\Resources\PackinglistResource;
use Filament\Resources\Pages\EditRecord;

class EditPackinglists extends EditRecord // <--- PASTIKAN INI SAMA
{
    protected static string $resource = PackinglistResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
{
    $packings = \App\Models\Packinglist::where('trip_id', $this->record->trip_id)->get();

    $data['items_repeater'] = $packings->map(function ($p) {
        return [
            'item_name' => $p->item_name,
            'is_checked' => $p->is_checked,
        ];
    })->toArray();

    return $data;
}

protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
{
    $tripId = $data['trip_id'] ?? $record->trip_id;
    
    // Hapus data barang lama biar ga double
    \App\Models\Packinglist::where('trip_id', $record->trip_id)->delete();

    $firstRecord = null;
    foreach ($data['items_repeater'] as $item) {
        $packing = \App\Models\Packinglist::create([
            'trip_id' => $tripId,
            'item_name' => $item['item_name'],
            'is_checked' => $item['is_checked'] ?? false,
        ]);
        if (!$firstRecord) { $firstRecord = $packing; }
    }

    return $firstRecord ?? $record;
}
}