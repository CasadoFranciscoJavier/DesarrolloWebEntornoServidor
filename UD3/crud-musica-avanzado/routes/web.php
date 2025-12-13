<?php

use Illuminate\Support\Facades\Route;
use App\Models\Autor;
use App\Models\Obra;
use App\Models\Periodo;
use App\Models\Tipo;
use App\Http\Controllers\AutorControlador;
use App\Http\Controllers\ObraControlador;

// Ruta principal: Listar todos los autores
Route::get('/', function () {
    $autores = Autor::with('periodos', 'obras')->get();
    return view('home', ['autores' => $autores]);
});

// Rutas para Autores
Route::get('/autor/create', function () {
    $periodos = Periodo::all();
    return view('crearAutor', ['periodos' => $periodos]);
});

Route::post('/autor', [AutorControlador::class, 'registrarAutor']);

Route::get('/autor/detalle/{id}', function ($id) {
    $autor = Autor::with('periodos', 'obras.tipos')->findOrFail($id);
    return view('detallesAutor', ['autor' => $autor]);
});

Route::get('/autor/edit/{id}', function ($id) {
    $autor = Autor::with('periodos')->findOrFail($id);
    $periodos = Periodo::all();
    return view('editarAutor', ['autor' => $autor, 'periodos' => $periodos]);
});

Route::post('/autor/edit/{id}', [AutorControlador::class, 'editarAutor']);

Route::get('/autor/delete/{id}', function ($id) {
    $autor = Autor::findOrFail($id);
    $autor->delete();
    return redirect('/')->with('success', 'Autor eliminado exitosamente');
});

// Rutas para Obras
Route::get('/obra/create/{autor_id}', function ($autor_id) {
    $autor = Autor::findOrFail($autor_id);
    $tipos = Tipo::all();
    return view('crearObra', ['autor' => $autor, 'tipos' => $tipos]);
});

Route::post('/obra', [ObraControlador::class, 'registrarObra']);

Route::get('/obra/delete/{id}', function ($id) {
    $obra = Obra::findOrFail($id);
    $autor_id = $obra->autor_id;
    $obra->delete();
    return redirect('/autor/detalle/' . $autor_id)->with('success', 'Obra eliminada exitosamente');
});
