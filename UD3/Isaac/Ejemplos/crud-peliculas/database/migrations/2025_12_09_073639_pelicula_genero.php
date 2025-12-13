<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelicula_genero', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('genero_id');
            $table->unsignedBigInteger('pelicula_id');

            $table->foreign('genero_id')->references('id')->on('generos')->onDelete('cascade');
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelicula_genero');
    }
};
