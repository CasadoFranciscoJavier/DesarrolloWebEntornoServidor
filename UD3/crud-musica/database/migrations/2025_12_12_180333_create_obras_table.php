<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); 
            $table->enum('tipo', [
                'Misa',
                'Motete, Pasión',
                'Magnificat, Responsorios',
                'Anthem',
                'Lamentaciones',
                'Vísperas'
            ])->nullable(); 
            
            $table->integer('anio')->nullable(); 

            $table->foreignId('autor_id')
            ->constrained('autores')
            ->onDelete('cascade'); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};

