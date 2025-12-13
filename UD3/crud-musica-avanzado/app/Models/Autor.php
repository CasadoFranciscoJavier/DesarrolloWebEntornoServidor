<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autores';

    protected $fillable = ['nombre', 'pais', 'foto_url'];

    // Relación uno a muchos: Un autor tiene muchas obras
    public function obras()
    {
        return $this->hasMany(Obra::class);
    }

    // Relación muchos a muchos: Un autor puede tener varios periodos
    public function periodos()
    {
        return $this->belongsToMany(Periodo::class, 'autor_periodo');
    }

    // Método helper para obtener los periodos como array de strings
    public function getPeriodos()
    {
        $periodos = [];
        foreach ($this->periodos as $periodo) {
            $periodos[] = $periodo->nombre;
        }
        return $periodos;
    }
}
