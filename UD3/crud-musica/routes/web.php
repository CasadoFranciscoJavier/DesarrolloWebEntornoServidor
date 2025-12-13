<?php

use App\Models\Autor;
use App\Models\Obra;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AutorControlador;
use App\Http\Controllers\ObraControlador;
use Illuminate\Validation\ValidationException;

Route::get('/', function () {
        $autores = Autor::all();
        return view('home', ['autores' => $autores]);
    });

Route::get('/autor/detalle/{id}', function ($id) {
    $autor = Autor::find($id);
    $obras = Obra::where('autor_id', $id)->orderBy('created_at', 'desc')->get();
    return view('detallesAutor', ['autor' => $autor, 'obras' => $obras]);
});

Route::get('/autor/create', function () {
    return view('crearAutor', [
        'periodos' => Autor::VALID_PERIODOS
    ]);
});

// Procesar el formulario y crear autor
Route::post('/autor', function (Request $request) {
    $controlador = new AutorControlador();

    try {
        $autor = $controlador->RegistrarAutor($request);
        $respuesta = redirect("/autor/detalle/" . $autor->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors())->withInput();
    }

    return $respuesta;

});


Route::get('/autor/edit/{id}', function ($id) {
    $autor = Autor::find($id);
    return view('editarAutor', ['autor' => $autor], [
        'periodos' => Autor::VALID_PERIODOS
    ]);
});

// Procesar la edición del autor
Route::post('/autor/edit/{id}', function ($id, Request $request) {
    $controlador = new AutorControlador();

    try {
        $autor = $controlador->editarAutor($id, $request);
        $respuesta = redirect("/autor/detalle/" . $autor->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
});



// Mostrar formulario para crear obra
Route::get('/obra/create/{autor_id}', function ($autor_id) {
    $autor = Autor::find($autor_id);
    return view('crearObra', [
        'autor' => $autor,
        'tipos' => Obra::VALID_TIPOS
    ]);
});

// Procesar el formulario y crear obra
Route::post('/obra', function (Request $request) {
    $controlador = new ObraControlador();

    try {
        $obra = $controlador->RegistrarObra($request);
        $respuesta = redirect("/autor/detalle/" . $obra->autor_id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors())->withInput();
    }

    return $respuesta;
});

Route::get('/autor/delete/{id}', function ($id) {
    $autor = Autor::find($id);

    if ($autor != null) {
        $autor->delete();
    }

    return redirect('/');
});

Route::get('/obra/delete/{id}', function ($id) {
    $obra = Obra::find($id);
    $ruta = '/';

    if ($obra != null) {
        $autorId = $obra->autor_id;
        $obra->delete();
        $ruta = '/autor/detalle/' . $autorId;
    }

    return redirect($ruta);
});