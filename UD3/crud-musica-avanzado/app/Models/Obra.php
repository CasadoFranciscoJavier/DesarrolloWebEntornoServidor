<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    protected $table = 'obras';

    protected $fillable = ['titulo', 'anio', 'autor_id'];

    // Eager loading: siempre carga los tipos al cargar una obra
    protected $with = ['tipos'];

    // Relación muchos a uno: Una obra pertenece a un autor
    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    // Relación muchos a muchos: Una obra puede ser de varios tipos
    public function tipos()
    {
        return $this->belongsToMany(Tipo::class, 'obra_tipo');
    }

    // Método helper para obtener los tipos como array de strings
    public function getTipos()
    {
        $tipos = [];
        foreach ($this->tipos as $tipo) {
            $tipos[] = $tipo->nombre;
        }
        return $tipos;
    }
}
