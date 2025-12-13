<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';

    protected $fillable = ['nombre'];

    // Un periodo puede tener muchos autores
    public function autores()
    {
        return $this->hasMany(Autor::class);
    }

    public const PERIODOS = [
        'Renacimiento',
        'Renacimiento tardío',
        'Barroco temprano',
        'Barroco',
        'Clasicismo',
        'Romanticismo',
    ];
}
