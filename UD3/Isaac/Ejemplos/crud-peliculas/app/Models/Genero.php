<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    /** @use HasFactory<\Database\Factories\GeneroFactory> */
    use HasFactory; // Ni caso a esto de momento

    protected $fillable = [
        'genero',
    ];

    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class, 'pelicula_genero');
    }
}
