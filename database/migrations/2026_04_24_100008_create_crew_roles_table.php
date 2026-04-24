<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crew_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. director, actor, producer
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crew_roles');
    }
};
