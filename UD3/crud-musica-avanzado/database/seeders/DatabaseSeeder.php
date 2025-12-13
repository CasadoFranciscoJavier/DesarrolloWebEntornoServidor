<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Autor;
use App\Models\Periodo;
use App\Models\Tipo;
use App\Models\Obra;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Insertar Periodos
        $periodos = [
            'Renacimiento',
            'Renacimiento tardío',
            'Barroco temprano',
            'Barroco',
            'Clasicismo',
            'Romanticismo',
        ];

        foreach ($periodos as $periodo) {
            Periodo::create(['nombre' => $periodo]);
        }

        // 2. Insertar Tipos de obras
        $tipos = [
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

        foreach ($tipos as $tipo) {
            Tipo::create(['nombre' => $tipo]);
        }

        // 3. Insertar Autores con sus periodos (muchos a muchos)

        // Johann Sebastian Bach
        $bach = Autor::create([
            'nombre' => 'Johann Sebastian Bach',
            'pais' => 'Alemania',
            'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/6a/Johann_Sebastian_Bach.jpg',
        ]);
        $bach->periodos()->attach(Periodo::whereIn('nombre', ['Barroco'])->pluck('id'));

        // Wolfgang Amadeus Mozart
        $mozart = Autor::create([
            'nombre' => 'Wolfgang Amadeus Mozart',
            'pais' => 'Austria',
            'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Wolfgang-amadeus-mozart_1.jpg',
        ]);
        $mozart->periodos()->attach(Periodo::whereIn('nombre', ['Clasicismo'])->pluck('id'));

        // Ludwig van Beethoven
        $beethoven = Autor::create([
            'nombre' => 'Ludwig van Beethoven',
            'pais' => 'Alemania',
            'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/6f/Beethoven.jpg',
        ]);
        // Beethoven está entre Clasicismo y Romanticismo
        $beethoven->periodos()->attach(Periodo::whereIn('nombre', ['Clasicismo', 'Romanticismo'])->pluck('id'));

        // Antonio Vivaldi
        $vivaldi = Autor::create([
            'nombre' => 'Antonio Vivaldi',
            'pais' => 'Italia',
            'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/d/d5/Antonio_Vivaldi.jpg',
        ]);
        $vivaldi->periodos()->attach(Periodo::whereIn('nombre', ['Barroco'])->pluck('id'));

        // 4. Insertar Obras con sus tipos (muchos a muchos)

        // Obras de Bach
        $misa = Obra::create([
            'titulo' => 'Misa en Si menor',
            'anio' => 1749,
            'autor_id' => $bach->id,
        ]);
        $misa->tipos()->attach(Tipo::whereIn('nombre', ['Misa', 'Oratorio'])->pluck('id'));

        $pasion = Obra::create([
            'titulo' => 'Pasión según San Mateo',
            'anio' => 1727,
            'autor_id' => $bach->id,
        ]);
        $pasion->tipos()->attach(Tipo::whereIn('nombre', ['Pasión', 'Oratorio'])->pluck('id'));

        $conciertos = Obra::create([
            'titulo' => 'Conciertos de Brandemburgo',
            'anio' => 1721,
            'autor_id' => $bach->id,
        ]);
        $conciertos->tipos()->attach(Tipo::whereIn('nombre', ['Concierto'])->pluck('id'));

        // Obras de Mozart
        $requiem = Obra::create([
            'titulo' => 'Réquiem en Re menor',
            'anio' => 1791,
            'autor_id' => $mozart->id,
        ]);
        $requiem->tipos()->attach(Tipo::whereIn('nombre', ['Réquiem', 'Misa'])->pluck('id'));

        $figaro = Obra::create([
            'titulo' => 'Las bodas de Fígaro',
            'anio' => 1786,
            'autor_id' => $mozart->id,
        ]);
        $figaro->tipos()->attach(Tipo::whereIn('nombre', ['Ópera'])->pluck('id'));

        $sinfonia40 = Obra::create([
            'titulo' => 'Sinfonía n.º 40',
            'anio' => 1788,
            'autor_id' => $mozart->id,
        ]);
        $sinfonia40->tipos()->attach(Tipo::whereIn('nombre', ['Sinfonía'])->pluck('id'));

        // Obras de Beethoven
        $sinfonia9 = Obra::create([
            'titulo' => 'Sinfonía n.º 9',
            'anio' => 1824,
            'autor_id' => $beethoven->id,
        ]);
        $sinfonia9->tipos()->attach(Tipo::whereIn('nombre', ['Sinfonía', 'Oratorio'])->pluck('id'));

        $sonata14 = Obra::create([
            'titulo' => 'Sonata Claro de Luna',
            'anio' => 1801,
            'autor_id' => $beethoven->id,
        ]);
        $sonata14->tipos()->attach(Tipo::whereIn('nombre', ['Sonata'])->pluck('id'));

        // Obras de Vivaldi
        $cuatroEstaciones = Obra::create([
            'titulo' => 'Las cuatro estaciones',
            'anio' => 1725,
            'autor_id' => $vivaldi->id,
        ]);
        $cuatroEstaciones->tipos()->attach(Tipo::whereIn('nombre', ['Concierto'])->pluck('id'));

        $gloria = Obra::create([
            'titulo' => 'Gloria en Re mayor',
            'anio' => 1715,
            'autor_id' => $vivaldi->id,
        ]);
        $gloria->tipos()->attach(Tipo::whereIn('nombre', ['Misa', 'Oratorio'])->pluck('id'));
    }
}
