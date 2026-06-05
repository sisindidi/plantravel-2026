<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('itineraries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('trip_id')->constrained()->onDelete('cascade'); 
    $table->integer('day_number'); // Hari ke-1, Hari ke-2, dst.
    $table->time('start_time');    // Jam mulai kegiatan
    $table->string('activity');    // Nama kegiatan (Contoh: Kunjungan ke Gunung Fuji)
    $table->text('notes')->nullable(); // Catatan tambahan (Contoh: Pakai baju tebal)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};
