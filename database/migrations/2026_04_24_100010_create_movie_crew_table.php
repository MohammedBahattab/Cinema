<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_crew', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->foreignId('crew_id')->constrained('crew')->cascadeOnDelete();
            $table->foreignId('crew_role_id')->constrained('crew_roles')->cascadeOnDelete();
            $table->unique(['movie_id', 'crew_id', 'crew_role_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_crew');
    }
};
