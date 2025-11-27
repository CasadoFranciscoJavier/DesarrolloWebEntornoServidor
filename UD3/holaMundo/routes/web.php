<?php

use Illuminate\Support\Facades\Route; // Importamos la clase Route

Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return view('hola', ['nombre' => $nombre]);
});
