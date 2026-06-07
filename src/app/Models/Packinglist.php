<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packinglist extends Model
{
    protected $fillable = ['trip_id', 'item_name', 'is_checked'];
    protected $casts = ['is_checked' => 'boolean'];
    
    public function trip() { return $this->belongsTo(Trip::class); }
}