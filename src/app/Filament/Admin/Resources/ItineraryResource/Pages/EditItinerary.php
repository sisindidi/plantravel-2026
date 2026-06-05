<?php

namespace App\Filament\Admin\Resources\ItineraryResource\Pages;

use App\Filament\Admin\Resources\ItineraryResource;
use App\Models\Itinerary;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItinerary extends EditRecord
{
    protected static string $resource = ItineraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // MEMBUAT DATA MUNCUL LAGI PAS EDIT: Tarik flat data DB, pecah jadi bentuk array nested form
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $tripId = $this->record->trip_id;
        $data['trip_id'] = $tripId;

        $allItineraries = Itinerary::where('trip_id', $tripId)
            ->orderBy('day_number', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $grouped = [];
        foreach ($allItineraries as $iti) {
            $grouped[$iti->day_number][] = [
                'start_time' => $iti->start_time,
                'activity' => $iti->activity,
                'notes' => $iti->notes,
            ];
        }

        $itinerariesByDay = [];
        foreach ($grouped as $dayNum => $activities) {
            $itinerariesByDay[] = [
                'day_number' => $dayNum,
                'activities_list' => $activities,
            ];
        }

        $data['itineraries_by_day'] = $itinerariesByDay;

        return $data;
    }

    // UPDATE LOGIC: Bersihkan rundown lama di trip ini, lalu timpa dengan isian form editan baru
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $tripId = $data['trip_id'];

        // Hapus massal data lama biar tidak menggulung duplikat
        Itinerary::where('trip_id', $tripId)->delete();

        $firstRecord = null;

        foreach ($data['itineraries_by_day'] as $dayData) {
            $dayNumber = $dayData['day_number'];

            foreach ($dayData['activities_list'] as $activityData) {
                $iti = Itinerary::create([
                    'trip_id' => $tripId,
                    'day_number' => $dayNumber,
                    'start_time' => $activityData['start_time'],
                    'activity' => $activityData['activity'],
                    'notes' => $activityData['notes'] ?? null,
                ]);

                if (!$firstRecord) {
                    $firstRecord = $iti;
                }
            }
        }

        return $firstRecord ?? $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}