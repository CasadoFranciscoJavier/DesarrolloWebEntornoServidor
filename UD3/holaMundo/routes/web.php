<?php

use App\Http\Controllers\Calculadora;
use Illuminate\Support\Facades\Route; // Importamos la clase Route

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

