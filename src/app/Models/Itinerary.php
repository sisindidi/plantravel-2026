<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'day_number',
        'start_time',
        'destination_id',
        'activity',
        'notes',
    ];

    /**
     * Relasi: Setiap Itinerary terikat pada satu Trip
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
 * Relasi: Satu Trip bisa punya banyak jadwal/itinerary
 */
public function itineraries(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(Itinerary::class);
}
}