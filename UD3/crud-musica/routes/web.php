<?php

use App\Models\Autor;
use App\Models\Obra;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AutorControlador;
use Illuminate\Validation\ObraControlador;

Route::get('/', function () {
        $autores = Autor::all();
        return view('home', ['autores' => $autores]);
    });

Route::get('/autor/detalle/{id}', function ($id) {
    $autor = Autor::find($id);
    $obras = Obra::where('autor_id', $id)->orderBy('created_at', 'desc')->get();
    return view('detallesAutor', ['autor' => $autor, 'obras' => $obras]);
});