<?php

use App\Http\Controllers\Calculadora;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route; // Importamos la clase Route
use Termwind\Components\Raw;
use Illuminate\Support\Facades\Request ;


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

// crea la pagina /registar-usuario con un formulario que permita 
// registar un nuevo usuario. Una vez registrado debe de ir  al detalle 
// del nuevo usuario /usuario/{id}
//===============================
Route::get('/usuario', function () {
    return view('registrar-usuario');
});

Route::get('/usuario/{id}', function ( Request $request) {
    return view('detalle-usuario');
});






