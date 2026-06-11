<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;

    // Daftarkan semua kolom database agar diizinkan menyimpan data
    protected $fillable = [
        'user_id',
        'title',
        'country_or_city',
        'start_date',
        'pax_count',
    ];

    /**
     * Hubungan balik ke User (Setiap Trip dimiliki oleh seorang User)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $guarded = [];

    
    public function packingLists(): HasMany
    {
        return $this->hasMany(Packinglist::class, 'trip_id');
    }
}
