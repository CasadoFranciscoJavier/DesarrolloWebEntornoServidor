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
        Schema::create('juegos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->integer('anio');
            $table->enum('genero', [
                'Acción',
                'Aventura',
                'RPG',
                'Estrategia',
                'Sandbox',
                'Música',
                'Pary',
                'Arcade'
            ]);
            $table->string('cover_url');


            $table->foreignId('compania_id')
                ->constrained('companias')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juegos');
    }
};
