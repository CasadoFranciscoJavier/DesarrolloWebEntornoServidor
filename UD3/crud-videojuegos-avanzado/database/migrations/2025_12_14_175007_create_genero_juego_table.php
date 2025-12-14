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
        Schema::create('genero_juego', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genero_id')->constrained('generos')->onDelete('cascade');
            $table->foreignId('juego_id')->constrained('juegos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genero_juego');
    }
};
