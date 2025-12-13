<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';

    protected $fillable = ['nombre'];

    // Un tipo puede tener muchas obras
    public function obras()
    {
        return $this->hasMany(Obra::class);
    }

    public const TIPOS = [
        'Misa',
        'Motete',
        'Pasión',
        'Magnificat',
        'Oratorio',
        'Cantata',
        'Concierto',
        'Sinfonía',
        'Sonata',
        'Ópera',
        'Suite',
        'Preludio y Fuga',
        'Variaciones',
        'Réquiem',
        'Serenata',
    ];
}
