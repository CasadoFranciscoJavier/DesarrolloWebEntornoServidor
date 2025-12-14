<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $fillable = [
        'titulo',
        'anio',
        'genero',
        'cover_url',
        'compania_id'
    ];


    public function compania()
    {
        return $this->belongsTo(Compania::class);
    }


   public const VALID_GENEROS = [
        'Acción',
                'Aventura',
                'RPG',
                'Estrategia',
                'Sandbox',
                'Música',
                'Pary',
                'Arcade'
    ];
}
