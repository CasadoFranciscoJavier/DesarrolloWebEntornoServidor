<?php

use App\Http\Controllers\PeliculaController;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/movies', function () {
    return Pelicula::all();
});

Route::get('/movies/{id}', function ($id) {
    // return Pelicula::with('generos')->find($id);
    // return Pelicula::find($id)->load('generos');

    return Pelicula::find($id);
});

Route::post('/movies', function (Request $request) {
    try {
        $peliculaControlador = new PeliculaController();
        $respuesta = $peliculaControlador->insertarPelicula($request);
    } catch (ValidationException $e) {
        $respuesta = $e->errors();
    }

    return $respuesta;
});

Route::put('/movies/{id}', function (Request $request, $id) {
    try {
        $peliculaControlador = new PeliculaController();
        $respuesta = $peliculaControlador->editarPelicula($request, $id);
    } catch (ValidationException $e) {
        $respuesta = $e->errors();
    }

    return $respuesta;
});

Route::delete('/movies/{id}', function ( $id) {
    return Pelicula::destroy($id);
});