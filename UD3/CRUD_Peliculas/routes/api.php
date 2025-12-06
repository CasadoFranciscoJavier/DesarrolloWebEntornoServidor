<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\peliculaControlador;
use App\Models\Pelicula;

use App\Http\Controllers\ComentarioControlador;
use App\Models\Comentario;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/movies', function () {
    $peliculas = Pelicula::all();
    return $peliculas;
});

Route::get('/movies/{id}', function ($id) {
    $pelicula = Pelicula::find($id);
    $comentarios = Comentario::where('pelicula_id', $id)->orderBy('created_at', 'desc')->get();
    return [$pelicula, $comentarios];
});

Route::post('/movies', function (Request $request) {

    $controlador = new peliculaControlador();

    try {
        $respuesta = $controlador->RegistrarPelicula($request);
    } catch (ValidationException $e) {
        $respuesta = $e->errors();
    }

    return $respuesta;

});

Route::put('/movies/{id}', function ($id, Request $request) {

    $controlador = new peliculaControlador();

    try {
        $respuesta = $controlador->editarPelicula($id,$request);
    } catch (ValidationException $e) {
        $respuesta = $e->errors();
    }

    return $respuesta;

});

Route::delete('/movies/{id}', function ($id) {

    $pelicula = Pelicula::find($id);

    if ($pelicula) {
        $pelicula->delete();
        return ['message' => 'Película eliminada correctamente'];
    }

    return ['error' => 'Película no encontrada'];

});
