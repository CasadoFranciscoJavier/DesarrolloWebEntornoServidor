<?php

use Illuminate\Support\Facades\Route;

Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return response()->json([
        'mensaje' => "Hola, $nombre!",
    ]);
});