<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('showtime_id')->constrained('showtimes')->noActionOnDelete();
            $table->foreignId('seat_id')->constrained('seats')->noActionOnDelete();
            $table->decimal('price', 8, 2);
            $table->unique(['showtime_id', 'seat_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};
