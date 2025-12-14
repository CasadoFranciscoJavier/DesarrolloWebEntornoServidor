<?php

use App\Models\Compania;
use App\Models\Juego;
use App\Models\Genero;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CompaniaControlador;
use App\Http\Controllers\JuegoControlador;


use Illuminate\Validation\ValidationException;

Route::get('/', function () {
    $companias = Compania::all();
    return view('home', ['companias' => $companias]);
});

Route::get('/compania/detalle/{id}', function ($id) {
    $compania = Compania::find($id);
    $juegos = Juego::where('compania_id', $id)->orderBy('created_at', 'desc')->get();
    return view('detallesCompania', ['compania' => $compania, 'juegos' => $juegos]);
});

Route::get('/compania/create', function () {
    return view('crearCompania', [
        'tipos' => Compania::VALID_TIPOS
    ]);
});

Route::post('/compania', function (Request $request) {
    $controlador = new CompaniaControlador();

    try {
        $compania = $controlador->RegistrarCompania($request);
        $respuesta = redirect("/compania/detalle/" . $compania->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors())->withInput();
    }

    return $respuesta;

});

Route::get('/compania/edit/{id}', function ($id) {
    $compania = Compania::find($id);
    return view('editarCompania', ['compania' => $compania]);
});


Route::post('/compania/edit/{id}', function ($id, Request $request) {
    $controlador = new CompaniaControlador();

    try {
        $compania = $controlador->editarCompania($id, $request);
        $respuesta = redirect("/compania/detalle/" . $compania->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
});


Route::get('/juego/create/{compania_id}', function ($compania_id) {
    $compania = Compania::find($compania_id);
    $generos = Genero::all();
    return view('crearJuego', [
        'compania' => $compania,
        'generos' => $generos
    ]);
});


Route::post('/juego', function (Request $request) {
    $controlador = new JuegoControlador();

    try {
        $juego = $controlador->RegistrarJuego($request);
        $respuesta = redirect("/compania/detalle/" . $juego->compania_id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors())->withInput();
    }

    return $respuesta;
});

Route::get('/juego/edit/{id}', function ($id) {
    $juego = Juego::find($id);
    $generos = Genero::all();
    return view('editarJuego', [
        'juego' => $juego,
        'generos' => $generos
    ]);
});


Route::post('/juego/edit/{id}', function ($id, Request $request) {
    $controlador = new JuegoControlador();

    try {
        $juego = $controlador->editarJuego($id, $request);
        $respuesta = redirect("/compania/detalle/" . $juego->compania_id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
});


Route::get('/compania/delete/{id}', function ($id) {
    $compania = Compania::find($id);

    if ($compania != null) {
        $compania->delete();
    }

    return redirect('/');
});

Route::get('/juego/delete/{id}', function ($id) {
    $juego = Juego::find($id);
    $ruta = '/';

    if ($juego != null) {
        $companiaId = $juego->compania_id;
        $juego->delete();
        $ruta = '/compania/detalle/' . $companiaId;
    }

    return redirect($ruta);
});
