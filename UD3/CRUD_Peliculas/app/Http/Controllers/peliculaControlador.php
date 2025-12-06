<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use Illuminate\Validation\Rule;


class peliculaControlador extends Controller
{
    public function ValidarPelicula(Request $request, $id = null)
    {
        // 1. Convertir el array de géneros permitidos a una cadena separada por comas
        $genresList = implode(',', Pelicula::VALID_GENRES);

        // 2. Definir la regla del título según si es creación o edición
        $titleRule = ['required', 'string', 'min:3', 'max:100'];

        if ($id == null) {
            $titleRule[] = 'unique:peliculas,title';
        } else {
            // Asegurar que el ID sea entero y especificar explícitamente la columna de ID
            $titleRule[] = Rule::unique('peliculas', 'title')->ignore((int)$id, 'id');
        }

        // 3. Definir todas las reglas de validación
        $rules = [
            'poster_url' => ['required', 'string', 'url', 'max:255'],
            'title' => $titleRule,
            'release_year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],

            // Regla para el array contenedor (genres)
            'genres' => ['required', 'array', 'min:1', 'distinct'],

            // Regla para cada elemento del array (genres.*)
            'genres.*' => ['required', 'string', 'in:' . $genresList],

            'synopsis' => ['required', 'string', 'min:10', 'max:5000'],
        ];

        // 4. Ejecutar la validación. Si falla, Laravel automáticamente redirige
        //    de vuelta con los errores y los datos de entrada.

        $request->validate($rules);


    }

    public function RegistrarPelicula(Request $request)
    {

        $this->ValidarPelicula($request);

        $data = $request->all();

        $peliculaNueva = Pelicula::create([
            'poster_url' => $data['poster_url'],
            'title' => $data['title'],
            'release_year' => $data['release_year'],
            'genres' => $data['genres'],
            'synopsis' => $data['synopsis'],
        ]);

        return $peliculaNueva;

    }

    public function editarPelicula($id, Request $request)
    {

        $this->ValidarPelicula($request, $id);

        $data = $request->all();
        $pelicula = Pelicula::find($id);

        if($pelicula){
            $pelicula->poster_url = $data['poster_url'];
            $pelicula->title = $data['title'];
            $pelicula->release_year = $data['release_year'];
            $pelicula->genres = $data['genres'];
            $pelicula->synopsis = $data['synopsis'];
    
            $pelicula->save();
        }

        return $pelicula;

    }
}
