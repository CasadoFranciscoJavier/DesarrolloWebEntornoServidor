<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    protected $table = 'companias';

    protected $fillable = [
        'nombre',
        'pais',
        'tipo',
    ];




    public function juegos()
    {
        return $this->hasMany(Juego::class);
    }

    public const VALID_TIPOS = [
        'Indie',
        'Pequeña',
        'Mediana',
        'Grande'
    ];
}
