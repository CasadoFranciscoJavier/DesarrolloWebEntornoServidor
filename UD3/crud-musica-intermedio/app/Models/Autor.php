<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autores';

    protected $fillable = ['nombre', 'pais', 'foto_url', 'periodo_id'];

    // Un autor pertenece a UN periodo
    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    // Un autor tiene muchas obras
    public function obras()
    {
        return $this->hasMany(Obra::class);
    }
}
