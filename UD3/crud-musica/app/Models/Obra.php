<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
     protected $fillable = [
        'titulo',
        'tipo',
        'anio',
        'autor_id',
    ];


    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }


   public const VALID_TIPOS = [
        'Misa',
        'Motete, Pasión',
        'Magnificat, Responsorios',
        'Anthem',
        'Lamentaciones',
        'Vísperas'
    ];
}

