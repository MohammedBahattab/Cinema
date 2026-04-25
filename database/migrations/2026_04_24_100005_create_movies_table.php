<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('duration_minutes');
            $table->date('release_date')->nullable();
            $table->string('poster_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('language')->nullable();
            $table->string('rating')->nullable();
            $table->foreignId('studio_id')->nullable()->constrained('studios')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
