<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Packinglist extends Model
{
    // Membuka pengisian mass-assignment
    protected $guarded = [];

    // FIX: Di dalam model anak, relasinya harus belongsTo ke arah Induk (Trip)
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}