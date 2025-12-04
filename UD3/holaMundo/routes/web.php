<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; // Importamos la clase Route
use App\Http\Controllers\Calculadora;
use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Validation\ValidationException;


Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return view('hola', ['nombre' => $nombre]);
});

Route::get('/edad/{edad?}', function ($edad = 18) {
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
Route::get('/nuevo_usuario', function () {
    return view('registrar-usuario');
});

// Procesar el formulario y crear usuario
Route::post('/usuario', function (Request $request) {
    $controlador = new UsuarioController();

    try {
        $usuario = $controlador->insertarUsuario($request);
        $respuesta = redirect("/usuario/" . $usuario->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;

});

// Mostrar detalle del usuario
Route::get('/usuario/{id}', function ($id) {
    $usuario = Usuario::find($id);
    return view('detalle-usuario', ['usuario' => $usuario]);
});


// Listar todos los usuarios
Route::get('/usuarios', function () {
    $usuarios = Usuario::all();
    return view('listar-usuarios', ['usuarios' => $usuarios]);
});

// Mostrar formulario de edición
Route::get('/usuario/{id}/editar', function ($id) {
    $usuario = Usuario::find($id);
    return view('editar-usuario', ['usuario' => $usuario]);
});

// Procesar la edición del usuario
Route::post('/usuario/{id}/editar', function ($id, Request $request) {
    $controlador = new UsuarioController();

    try {
        $usuario = $controlador->editarUsuario($id, $request);
        $respuesta = redirect("/usuario/" . $usuario->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;

});

//eliminar usuario
Route::delete('/usuario/{id}/delete', function ($id) {
    Usuario::destroy($id);
    return redirect('/usuarios');
});

