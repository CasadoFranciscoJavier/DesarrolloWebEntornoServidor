<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autores';

    protected $fillable = [
        'nombre',
        'pais',
        'periodo',
        'foto_url',
    ];


    

    public function obras()
    {
        return $this->hasMany(Obra::class);
    }

    public const VALID_PERIODOS = [
        'Renacimiento',
        'Renacimiento tardío',
        'Barroco temprano',
        'Barroco',
        'Clasicismo',
        'Romanticismo'
    ];
}
