<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $fillable = [
        'titulo',
        'anio',
        'cover_url',
        'compania_id'
    ];

    public function compania()
    {
        return $this->belongsTo(Compania::class);
    }

    public function generos()
    {
        return $this->belongsToMany(Genero::class, 'genero_juego');
    }
}
