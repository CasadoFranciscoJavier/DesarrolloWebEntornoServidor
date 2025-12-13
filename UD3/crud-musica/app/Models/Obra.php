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
        'Motete',
        'Pasión',
        'Magnificat',
        'Oficio de difuntos',
        'Responsorios',
        'Anthem',
        'Lamentaciones',
        'Madrigal espiritual',
        'Vísperas',
        'Colección sacra',
        'Salmo',
        'Oratorio',
        'Gloria',
        'Stabat Mater',
        'Requiem',
        'Himno'
    ];
}

