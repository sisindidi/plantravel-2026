<?php

namespace App\Filament\Admin\Resources\ItineraryResource\Pages;

use App\Filament\Admin\Resources\ItineraryResource;
use App\Models\Itinerary;
use Filament\Resources\Pages\CreateRecord;

class CreateItinerary extends CreateRecord
{
    protected static string $resource = ItineraryResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $tripId = $data['trip_id'];
        $firstRecord = null;

        foreach ($data['itineraries_by_day'] as $dayData) {
            $dayNumber = $dayData['day_number'];

            foreach ($dayData['activities_list'] as $activityData) {
                $itinerary = Itinerary::create([
                    'trip_id' => $tripId,
                    'day_number' => $dayNumber,
                    'start_time' => $activityData['start_time'],
                    'activity' => $activityData['activity'],
                    'notes' => $activityData['notes'] ?? null,
                ]);

                if (!$firstRecord) {
                    $firstRecord = $itinerary;
                }
            }
        }

        return $firstRecord; 
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}