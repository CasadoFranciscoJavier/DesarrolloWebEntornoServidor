<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';

    protected $fillable = ['nombre'];

    // Relación muchos a muchos: Un periodo puede tener varios autores
    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_periodo');
    }
}
