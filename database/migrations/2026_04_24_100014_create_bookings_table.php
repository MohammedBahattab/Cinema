<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('guest_user_id')->nullable()->constrained('guest_users')->nullOnDelete();
            $table->foreignId('showtime_id')->constrained('showtimes')->cascadeOnDelete();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });

        // Add a CHECK constraint to ensure either user_id OR guest_user_id is not null, but not both
        DB::statement('ALTER TABLE bookings ADD CONSTRAINT chk_bookings_user_guest CHECK (
            (user_id IS NOT NULL AND guest_user_id IS NULL) OR 
            (user_id IS NULL AND guest_user_id IS NOT NULL)
        )');
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            DB::statement('ALTER TABLE bookings DROP CONSTRAINT chk_bookings_user_guest');
        });
        Schema::dropIfExists('bookings');
    }
};
