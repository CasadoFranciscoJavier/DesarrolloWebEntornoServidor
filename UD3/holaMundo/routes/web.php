<?php

use App\Http\Controllers\Calculadora;
use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;


Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return view('hola', ['nombre' => $nombre]);
});

Route::get('/edad/{edad?}', function ($edad = 8) {
    return view('edad', ['edad' => $edad]);
});


Route::get('/numeros/{size?}', function ($size) {
    $calculadora = new Calculadora();
    $numeros = $calculadora->obtenerListaNumeros($size);

    return view('numeros', [
        'numeros' => $numeros,
        'size' => $size
    ]);
});

// Mostrar formulario de registro
Route::get('/usuario', function () {
    return view('registrar-usuario');
});

// Procesar el formulario y crear usuario
Route::post('/usuario', [UsuarioController::class, 'insertarUsuario']);

// Mostrar detalle del usuario
Route::get('/usuario/{id}', function ($id) {
    $usuario = Usuario::find($id);
    return view('detalle-usuario', ['usuario' => $usuario]);
});






