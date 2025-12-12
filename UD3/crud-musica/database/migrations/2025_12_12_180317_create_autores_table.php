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
        Schema::create('autores', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // obligatorio
        $table->string('pais')->nullable(); // opcional
        $table->enum('periodo', [
            'Renacimiento',
            'Renacimiento tardío',
            'Barroco temprano',
            'Barroco',
            'Clasicismo',
            'Romanticismo'
        ])->nullable(); 
        $table->string('foto_url')->nullable(); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autores');
    }
};
