<?php

use App\Http\Controllers\Calculadora;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Validation\ValidationException;

// endpoint de tipo GET para la URL /hola/{nombre}
Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return response()->json([
        'mensaje' => "Hola, $nombre!",
    ]);
});

Route::get('/sumar/{n1}/{n2}', function ($n1, $n2) {
    $calculadora = new Calculadora();
    $resultadoSuma = $calculadora->sumar($n1, $n2);
    return $resultadoSuma;
});

Route::get('/numeros/{size}', function ($size) {
    $calculadora = new Calculadora();
    $numeros = $calculadora->obtenerListaNumeros($size);
    return $numeros;
});

// =========================== API USUARIOS =========================== //

// Route::post('/usuario', function (Request $request) {

//     $usuarioNuevo = Usuario::create([
//         'nombre' => $request->input('nombre'),
//         'email' => $request->input('email'),
//     ]);

//     return $usuarioNuevo;

// });

Route::get('/usuario', function () {

    return Usuario::all();

});

Route::get('/usuario/{id}', function ($id) {

    return Usuario::find($id);

});

Route::post('/usuario', function (Request $request) {

    $controlador = new UsuarioController();

    try {
        $respuesta = $controlador->insertarUsuario($request);
    } catch (ValidationException $e) {
        $respuesta = $e->errors();
    }

    return $respuesta;

});

Route::put('/usuario/{id}', function ($id, Request $request) {

    $controlador = new UsuarioController();

    try {
        $respuesta = $controlador->editarUsuario($id,$request);
    } catch (ValidationException $e) {
        $respuesta = $e->errors();
    }

    return $respuesta;

});

Route::delete('/usuario/{id}', function ($id) {

    return Usuario::destroy($id);

});