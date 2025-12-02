<?php

use Illuminate\Support\Facades\Route; // Importamos la clase Route

Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return view('hola', ['nombre' => $nombre]);
});

Route::get('/edad/{edad?}', function ($edad = 8) {
    return view('edad', ['edad' => $edad]);
});
