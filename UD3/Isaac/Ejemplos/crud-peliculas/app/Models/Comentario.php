<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    /** @use HasFactory<\Database\Factories\ComentarioFactory> */
    use HasFactory; // Ni caso a esto de momento

    protected $fillable = [
        'texto',
        'pelicula_id',
        'user_id',
    ];

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
