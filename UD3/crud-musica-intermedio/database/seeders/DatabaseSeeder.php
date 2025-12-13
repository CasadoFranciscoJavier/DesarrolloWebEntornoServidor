<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        // 1. Crear Periodos usando la constante del modelo
        foreach (Periodo::PERIODOS as $periodo) {
            Periodo::create(['nombre' => $periodo]);
        }

        // 2. Crear Tipos de obras usando la constante del modelo
        foreach (Tipo::TIPOS as $tipo) {
            Tipo::create(['nombre' => $tipo]);
        }

        // 3. Crear Autores con su periodo (belongsTo)

        // Johann Sebastian Bach - Barroco
        $bach = Autor::create([
            'nombre' => 'Johann Sebastian Bach',
            'pais' => 'Alemania',
            'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/6a/Johann_Sebastian_Bach.jpg',
            'periodo_id' => Periodo::where('nombre', 'Barroco')->first()->id,
        ]);

        // Wolfgang Amadeus Mozart - Clasicismo
        $mozart = Autor::create([
            'nombre' => 'Wolfgang Amadeus Mozart',
            'pais' => 'Austria',
            'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Wolfgang-amadeus-mozart_1.jpg',
            'periodo_id' => Periodo::where('nombre', 'Clasicismo')->first()->id,
        ]);

        // Ludwig van Beethoven - Romanticismo
        $beethoven = Autor::create([
            'nombre' => 'Ludwig van Beethoven',
            'pais' => 'Alemania',
            'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/6f/Beethoven.jpg',
            'periodo_id' => Periodo::where('nombre', 'Romanticismo')->first()->id,
        ]);

        // Antonio Vivaldi - Barroco
        $vivaldi = Autor::create([
            'nombre' => 'Antonio Vivaldi',
            'pais' => 'Italia',
            'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/d/d5/Antonio_Vivaldi.jpg',
            'periodo_id' => Periodo::where('nombre', 'Barroco')->first()->id,
        ]);

        // 4. Crear Obras con sus tipos (belongsTo)

        // Obras de Bach
        Obra::create([
            'titulo' => 'Misa en Si menor',
            'anio' => 1749,
            'autor_id' => $bach->id,
            'tipo_id' => Tipo::where('nombre', 'Misa')->first()->id,
        ]);

        Obra::create([
            'titulo' => 'Pasión según San Mateo',
            'anio' => 1727,
            'autor_id' => $bach->id,
            'tipo_id' => Tipo::where('nombre', 'Pasión')->first()->id,
        ]);

        Obra::create([
            'titulo' => 'Conciertos de Brandemburgo',
            'anio' => 1721,
            'autor_id' => $bach->id,
            'tipo_id' => Tipo::where('nombre', 'Concierto')->first()->id,
        ]);

        // Obras de Mozart
        Obra::create([
            'titulo' => 'Réquiem en Re menor',
            'anio' => 1791,
            'autor_id' => $mozart->id,
            'tipo_id' => Tipo::where('nombre', 'Réquiem')->first()->id,
        ]);

        Obra::create([
            'titulo' => 'Las bodas de Fígaro',
            'anio' => 1786,
            'autor_id' => $mozart->id,
            'tipo_id' => Tipo::where('nombre', 'Ópera')->first()->id,
        ]);

        Obra::create([
            'titulo' => 'Sinfonía n.º 40',
            'anio' => 1788,
            'autor_id' => $mozart->id,
            'tipo_id' => Tipo::where('nombre', 'Sinfonía')->first()->id,
        ]);

        // Obras de Beethoven
        Obra::create([
            'titulo' => 'Sinfonía n.º 9',
            'anio' => 1824,
            'autor_id' => $beethoven->id,
            'tipo_id' => Tipo::where('nombre', 'Sinfonía')->first()->id,
        ]);

        Obra::create([
            'titulo' => 'Sonata Claro de Luna',
            'anio' => 1801,
            'autor_id' => $beethoven->id,
            'tipo_id' => Tipo::where('nombre', 'Sonata')->first()->id,
        ]);

        // Obras de Vivaldi
        Obra::create([
            'titulo' => 'Las cuatro estaciones',
            'anio' => 1725,
            'autor_id' => $vivaldi->id,
            'tipo_id' => Tipo::where('nombre', 'Concierto')->first()->id,
        ]);

        Obra::create([
            'titulo' => 'Gloria en Re mayor',
            'anio' => 1715,
            'autor_id' => $vivaldi->id,
            'tipo_id' => Tipo::where('nombre', 'Misa')->first()->id,
        ]);
    }
}
