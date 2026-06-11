<?php

namespace App\Filament\Admin\Resources\DestinationResource\Pages;

use App\Filament\Admin\Resources\DestinationResource;
use App\Models\Destination;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditDestination extends EditRecord
{
    protected static string $resource = DestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $destinations = Destination::where('trip_id', $this->record->trip_id)->get();

        // BERSIH: Hanya mapping properti 'name' agar repeater menampilkan data sebelumnya dengan pas
        $data['destinations_repeater'] = $destinations->map(function ($dest) {
            return [
                'name' => $dest->name,
            ];
        })->toArray();

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $tripId = $data['trip_id'] ?? $record->trip_id;
        $destinations = $data['destinations_repeater'] ?? [];

        // Hapus massal data lama biar gak numpuk/double pas disave editan baru
        Destination::where('trip_id', $record->trip_id)->delete();

        $firstRecord = null;
        foreach ($destinations as $dest) {
            $destination = Destination::create([
                'trip_id' => $tripId,
                'name' => $dest['name'],
            ]);

            if (!$firstRecord) {
                $firstRecord = $destination;
            }
        }

        return $firstRecord ?? $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}