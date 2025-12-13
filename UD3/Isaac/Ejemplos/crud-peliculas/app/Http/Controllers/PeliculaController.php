<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;
use App\Models\Pelicula;

class PeliculaController extends Controller
{

    static function obtenerGenerosPelicula($request) {
        $generos = $request->input('generos');
        $generosIDs = Genero::whereIn('genero', $generos)->pluck('id'); // SELECT id FROM generos WHERE genero IN (...)

        return $generosIDs;
    }

    static function validarPelicula(Request $request) {
        $validation = $request->validate([
            'titulo' => 'required|string|max:255',
            'poster' => 'required|url|max:500',
            'anio' => 'required|integer|min:1888',
            'sinopsis' => 'required|string',
            'generos' => 'required|array|min:1',
            'generos.*' => 'string|exists:generos,genero',
        ]);
    }

    static function insertarPelicula(Request $request) {
        PeliculaController::validarPelicula($request);
        
        $pelicula = Pelicula::create([
            'titulo' => $request->input('titulo'),
            'poster' => $request->input('poster'),
            'anio' => $request->input('anio'),
            'sinopsis' => $request->input('sinopsis'),
        ]);

        $generos = PeliculaController::obtenerGenerosPelicula($request);
        $pelicula->generos()->attach($generos);

        $pelicula->load('generos'); // Cargar los géneros asociados antes de devolver la película, si no, saldría solo la película sin sus géneros

        return $pelicula;
    }

    static function editarPelicula(Request $request, $id) {
        PeliculaController::validarPelicula($request);
        
        $pelicula = Pelicula::find($id);
        
        $pelicula->update([
            'titulo' => $request->input('titulo'),
            'poster' => $request->input('poster'),
            'anio' => $request->input('anio'),
            'sinopsis' => $request->input('sinopsis'),
        ]);

        $generos = PeliculaController::obtenerGenerosPelicula($request);
        $pelicula->generos()->sync($generos); // Pongo sync para actualizar los géneros asociados, borra primero la anterior relación y escribe la nueva

        $pelicula->load('generos');
        return $pelicula;
    }
}
