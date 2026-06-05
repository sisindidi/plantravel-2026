<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    // Membuka pengisian mass-assignment agar data array aman masuk database
    protected $guarded = [];

    // RELASI: 1 row budget mencakup ke 1 Trip utama
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}