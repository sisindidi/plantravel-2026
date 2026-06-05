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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Mengunci data per user
            $table->string('title'); // Contoh: "Liburan Jogja"
            $table->string('country_or_city'); // Tujuan Utama
            $table->date('start_date');
            $table->integer('pax_count')->default(1); // Jumlah peserta
            $table->timestamps();
        }); // <-- KALAU ERROR TADI, BIASANYA LU LUPA ATAU KEBUSKES TUTUPAN INI!
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};