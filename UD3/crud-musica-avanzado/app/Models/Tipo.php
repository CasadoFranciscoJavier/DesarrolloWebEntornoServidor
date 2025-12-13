<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';

    protected $fillable = ['nombre'];

    // Relación muchos a muchos: Un tipo puede tener varias obras
    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'obra_tipo');
    }
}
