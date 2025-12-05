<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    protected $fillable = [
        'poster_url',
        'title',
        'release_year',
        'genres',
        'synopsis',
    ];


    protected $casts = [
        'genres' => 'array',
    ];

    public function comments()
    {
        return $this->hasMany(Comentario::class);
    }

    public const VALID_GENRES = [
        'Action',
        'Comedy',
        'Drama',
        'Horror',
        'Sci-Fi',
        'Fantasy',
        'Documentary',
        'Romance'
    ];
}
