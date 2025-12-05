<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeliculasModel;


class peliculaControlador extends Controller
{
    public function Crear(Request $request)
    {
        // 1. Convertir el array de géneros permitidos a una cadena separada por comas
        $genresList = implode(',', PeliculasModel::VALID_GENRES);

        // 2. Definir todas las reglas de validación
        $rules = [
            'poster_url' => ['required', 'string', 'url', 'max:255'],
            'title' => ['required', 'string', 'min:3', 'max:100', 'unique:movies,title'], // Usamos 'movies' si renombraste la tabla
            'release_year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],

            // Regla para el array contenedor (genres)
            'genres' => ['required', 'array', 'min:1', 'distinct'],

            // Regla para cada elemento del array (genres.*)
            'genres.*' => ['required', 'string', 'in:' . $genresList],

            'synopsis' => ['required', 'string', 'min:10', 'max:5000'],
        ];

        // 3. Ejecutar la validación. Si falla, Laravel automáticamente redirige
        //    de vuelta con los errores y los datos de entrada.
        $validatedData = $request->validate($rules);

        // 4. Lógica de creación (solo se ejecuta si la validación es exitosa)
        // Ya que la validación pasó, procedemos con la asignación masiva
        $pelicula = PeliculasModel::create($validatedData);

        // 5. Un solo punto de salida (siguiendo tu restricción)
        return redirect()->route('movie.detail', $pelicula->id)
            ->with('success', 'Película creada exitosamente.');
    }
}
