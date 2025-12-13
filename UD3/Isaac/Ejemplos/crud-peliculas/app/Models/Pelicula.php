<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    /** @use HasFactory<\Database\Factories\PeliculaFactory> */
    use HasFactory; // Ni caso a esto de momento

    protected $with = ['generos']; // Siempre que se obtenga una Pelicula, traerá también sus géneros

    protected $fillable = [
        'titulo',
        'poster',
        'anio',
        'sinopsis',
    ];

    public function generos()
    {
        return $this->belongsToMany(Genero::class, 'pelicula_genero'); // Le pongo el nombre de la tabla intermedia porque Laravel busca genero_pelicula por defecto
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function getGeneros()
    {
        $generos = [];
        foreach ($this->generos as $genero) {
            $generos[] = $genero->genero;
        }
        return $generos;
        // return $this->generos->pluck('genero')->toArray();
    }
}
