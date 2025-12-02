<?php
use App\Http\Controllers\Calculadora;
use Illuminate\Support\Facades\Route;

Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return response()->json([
        'mensaje' => "Hola, $nombre!",
    ]);
});


Route::get('/sumar/{n1?}/{n2?}', [Calculadora:: class,'sumar'] );

Route::get('/numeros/{size}', [Calculadora:: class,'obtenerListaNumeros'] );