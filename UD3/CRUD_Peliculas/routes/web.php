<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\peliculaControlador;
use App\Models\Pelicula;

use App\Http\Controllers\ComentarioControlador;
use App\Models\Comentario;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

Route::get('/', function () {
    $peliculas = Pelicula::paginate(10);  //SIN paginación: Pelicula::all() → Trae TODAS las películas (las 20)
    return view('home', ['peliculas' => $peliculas]);
})->middleware('auth');  // solo usuarios autentificados

// http://localhost:8000/ → Página 1 (películas 1-10)
// http://localhost:8000/?page=2 → Página 2 (películas 11-20)
// Laravel automáticamente lee ?page=2 de la URL y sabe qué películas mostrar.

Route::get('/movie/create', function () {
    return view('registrar-pelicula');
})->middleware(['auth', 'role:admin']);

// Procesar el formulario y crear película
Route::post('/movie', function (Request $request) {
    $controlador = new peliculaControlador();

    try {
        $pelicula = $controlador->RegistrarPelicula($request);
        $respuesta = redirect("/movie/detail/" . $pelicula->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;

});


Route::get('/movie/detail/{id}', function ($id) {
    $pelicula = Pelicula::find($id);
    $comentarios = Comentario::where('pelicula_id', $id)->orderBy('created_at', 'desc')->get();
    return view('detalle-pelicula', ['pelicula' => $pelicula, 'comentarios' => $comentarios]);
})->middleware('auth');



// Mostrar formulario de edición de película
Route::get('/movie/edit/{id}', function ($id) {
    $pelicula = Pelicula::find($id);
    return view('editar-pelicula', ['pelicula' => $pelicula]);
})->middleware(['auth', 'role:admin']);

// Procesar la edición de la película
Route::post('/movie/edit/{id}', function ($id, Request $request) {
    $controlador = new peliculaControlador();

    try {
        $pelicula = $controlador->editarPelicula($id, $request);
        $respuesta = redirect("/movie/detail/" . $pelicula->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
})->middleware(['auth', 'role:admin']);

// Borrar película
Route::get('/movie/delete/{id}', function ($id) {
    $pelicula = Pelicula::find($id);

    if ($pelicula != null) {
        $pelicula->delete();
    }

    return redirect('/');
})->middleware(['auth', 'role:admin']);

// Crear comentario
Route::post('/comments/create', function (Request $request) {
    $controlador = new ComentarioControlador();

    try {
        $comentario = $controlador->RegistrarComentario($request);
        $respuesta = redirect("/movie/detail/" . $comentario->pelicula_id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
})->middleware('auth');

// Borrar comentario
Route::get('/comments/delete/{id}', function ($id) {
    $comentario = Comentario::find($id);
    $peliculaId = 1;

    if ($comentario != null) {
        $peliculaId = $comentario->pelicula_id;
        $comentario->delete();
    }

    return redirect("/movie/detail/" . $peliculaId);
})->middleware(['auth', 'role:admin']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
