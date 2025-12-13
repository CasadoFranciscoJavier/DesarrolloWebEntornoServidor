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
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->integer('anio')->nullable();
            // Relación con autores: Una obra pertenece a UN autor
            $table->foreignId('autor_id')->constrained('autores')->onDelete('cascade');
            // Relación con tipos: Una obra pertenece a UN tipo
            $table->foreignId('tipo_id')->nullable()->constrained('tipos')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};
