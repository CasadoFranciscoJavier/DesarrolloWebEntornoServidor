<?php

use App\Http\Controllers\Calculadora;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Http\Controllers\UsuarioController;


Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return response()->json([
        'mensaje' => "Hola, $nombre!",
    ]);
});


Route::get('/sumar/{n1?}/{n2?}', [Calculadora::class, 'sumar']);

Route::get('/numeros/{size}', [Calculadora::class, 'obtenerListaNumeros']);



// OPCION 1

// Route::post('/usuario', function (Request $request) {
//     $usuarioNuevo = Usuario::create([
//         'nombre' => $request->input('nombre'),
//         'email' => $request->input('email'),
//     ]);

//     return $usuarioNuevo;
//     // return $request->getContent();
// });

// OPCION 2

// Route::post('/usuario', function (Request $request) {

//     $data = json_decode($request->getContent(), true);
//     $usuarioNuevo = Usuario::create([
//         'nombre' => $data['nombre'],
//         'email' => $data['email'],
//     ]);

//     return $usuarioNuevo;
// });


// OPCION 3 (mejor)
// Insertar nuevo usuario
Route::post('/usuario', function (Request $request) {

    $data = $request->all();
    $usuarioNuevo = Usuario::create([
        'nombre' => $data['nombre'],
        'email' => $data['email'],
    ]);

    return $usuarioNuevo;
});



// GET: Obtener un usuario por ID
Route::get('/usuario/{id}', function ($id) {
    $usuario = Usuario::find($id);


    return $usuario;
});



// GET: Obtener todos los usuarios
Route::get('/usuario', function () {
    $usuarios = Usuario::all();
    return $usuarios;
});


//PUT: Actualizar un usuario
Route::put('/usuario/{id}', function ($id, Request $request) {
   $data = $request->all();
    $usuario = Usuario::find($id);
    
    $usuario -> nombre = $data['nombre'];
    $usuario -> email = $data['email'];
    
    $usuario->save();

    return $usuario;
});


//DELETE: Eliminar un registro
Route::delete('/usuario/{id}', function ($id) {
    $usuario = Usuario::destroy($id);


    return $usuario;
});

