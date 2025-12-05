<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'pelicula_id',
        'user_id',
        'content',
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
