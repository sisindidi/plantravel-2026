<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = ['trip_id', 'name', 'visit_date'];

    public function trip() {
    return $this->belongsTo(Trip::class);
}
}