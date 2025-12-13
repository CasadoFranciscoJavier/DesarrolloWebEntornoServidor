<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    protected $table = 'obras';

    protected $fillable = ['titulo', 'anio', 'autor_id', 'tipo_id'];

    // Una obra pertenece a UN autor
    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    // Una obra pertenece a UN tipo
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
}
