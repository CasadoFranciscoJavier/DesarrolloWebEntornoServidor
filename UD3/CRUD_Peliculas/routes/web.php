<?php

use Illuminate\Support\Facades\Route;
use App\Models\Pelicula;

Route::get('/', function () {
    $peliculas = Pelicula::paginate(10);  //SIN paginación: Pelicula::all() → Trae TODAS las películas (las 20)
    return view('home', ['peliculas' => $peliculas]);
})->middleware('auth');  // solo usuarios autentificados

// http://localhost:8000/ → Página 1 (películas 1-10)
// http://localhost:8000/?page=2 → Página 2 (películas 11-20)
// Laravel automáticamente lee ?page=2 de la URL y sabe qué películas mostrar.

Route::get('/panel-admin', function () {
    return view('panel-admin');
})->middleware('role:admin');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
