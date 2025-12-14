<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
   protected $table = 'generos';

    protected $fillable = ['nombre'];


    public function juegos()
    {
        return $this->belongsToMany(Juego::class, 'genero_juego');
    }
}
