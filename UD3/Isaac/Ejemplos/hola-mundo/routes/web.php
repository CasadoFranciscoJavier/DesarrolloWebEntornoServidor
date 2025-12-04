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

Route::get('/numeros/{size}', function ($size) {
    $calculadora = new Calculadora();
    $numeros = $calculadora->obtenerListaNumeros($size);

    return view('numeros', [
        'numeros' => $numeros,
        'size' => $size
    ]);
});

Route::get('/registrar-usuario', function () {
    return view('registrarUsuario');
});

Route::get('/usuario/{id}', function ($id) {
    $usuario = Usuario::find($id);
    return view('detalleUsuario', ['usuario' => $usuario]);
});

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
