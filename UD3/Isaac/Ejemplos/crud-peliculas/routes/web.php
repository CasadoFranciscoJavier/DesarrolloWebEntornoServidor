<?php

use App\Models\Comentario;
use App\Models\Genero;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PeliculaController;
use Illuminate\Validation\ValidationException;

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        $peliculas = Pelicula::all();
        return view('lista-peliculas', ['peliculas' => $peliculas]);
    });

    Route::get('/movie/detail/{id}', function ($id) {
        $pelicula = Pelicula::findOrFail($id);
        return view('detalle-peliculas', ['pelicula' => $pelicula]);
    });

    Route::post('/comments/create', function (Request $request) {
        Comentario::create([
            'texto' => $request->input('texto'),
            'pelicula_id' => $request->input('pelicula_id'),
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->back();
    });

});

Route::group(['middleware' => 'role:admin'], function () {

    Route::get('/movie/create', function () {
        $generos = Genero::all();
        return view('nueva-pelicula', ['generos' => $generos]);
    });

    Route::post('/movie/create', function (Request $request) {
        try {
            $pelicula = PeliculaController::insertarPelicula($request);
            $salida = redirect("/movie/detail/{$pelicula->id}");
        } catch (ValidationException $e) {
            $salida = redirect()->back()->withErrors($e->errors())->withInput();
        }

        return $salida;

    });

    Route::get('/movie/update/{id}', function ($id) {
        $pelicula = Pelicula::findOrFail($id);
        $generos = Genero::all();
        return view('editar-pelicula', ['generos' => $generos, 'pelicula' => $pelicula]);
    });

    Route::post('/movie/update/{id}', function (Request $request, $id) {
        try {
            $pelicula = PeliculaController::editarPelicula($request, $id);
            $salida = redirect("/movie/detail/{$pelicula->id}");
        } catch (ValidationException $e) {
            $salida = redirect()->back()->withErrors($e->errors())->withInput();
        }

        return $salida;
    });

    Route::get('/comments/delete/{id}', function ($id) {
        Comentario::destroy($id);
        return redirect()->back();
    });

});


Auth::routes();