<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use Illuminate\Validation\Rule;


class peliculaControlador extends Controller
{
    public function ValidarPelicula(Request $request, $id = null)
    {
        $genresList = implode(',', Pelicula::VALID_GENRES);

        $titleRule = ['required', 'string', 'min:3', 'max:100'];

        if ($id == null) {
            $titleRule[] = 'unique:peliculas,title';
        } else {
            // Asegurar que el ID sea entero y especificar explícitamente la columna de ID
            $titleRule[] = Rule::unique('peliculas', 'title')->ignore((int)$id, 'id');
        }

        $rules = [
            'poster_url' => ['required', 'string', 'url', 'max:255'],
            'title' => $titleRule,
            'release_year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'genres' => ['required', 'array', 'min:1', 'distinct'],
            'genres.*' => ['required', 'string', 'in:' . $genresList],
            'synopsis' => ['required', 'string', 'min:10', 'max:5000'],
        ];

   

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
