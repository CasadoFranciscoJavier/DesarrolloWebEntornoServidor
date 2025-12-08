<?php


use App\Http\Controllers\peliculaControlador;
use App\Models\Pelicula;
use App\Models\Comentario;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;




Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::get('/movies', function () {
  $peliculas = Pelicula::all();
  return $peliculas;
});

Route::get('/movies/{id}', function ($id) {
  $pelicula = Pelicula::find($id);
  $comentarios = Comentario::where('pelicula_id', $id)->orderBy('created_at', 'desc')->get();
  return [$pelicula, $comentarios];
});

Route::post('/movies', function (Request $request) {

  $controlador = new peliculaControlador();
  $respuesta = null;

  try {
    $respuesta = $controlador->RegistrarPelicula($request);
  } catch (ValidationException $e) {
    $respuesta = $e->errors();
  }

  return $respuesta;

});

Route::put('/movies/{id}', function ($id, Request $request) {

  $controlador = new peliculaControlador();
  $respuesta = null;

  try {
    $respuesta = $controlador->editarPelicula($id,$request);
  } catch (ValidationException $e) {
    $respuesta = $e->errors();
  }

  return $respuesta;

});

Route::delete('/movies/{id}', function ($id) {

    $pelicula = Pelicula::find($id);
    $respuesta = null;

  if ($pelicula) {
    $pelicula->delete();
    $respuesta = ['message' => 'Película eliminada correctamente'];
  } else {
      $respuesta = ['error' => 'Película no encontrada'];
    }
    
    return $respuesta; 
});

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\PeliculaApiController;
// use Illuminate\Http\Request;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// // Rutas API con controlador documentado para Swagger
// Route::get('/movies', [PeliculaApiController::class, 'index']);
// Route::get('/movies/{id}', [PeliculaApiController::class, 'show']);
// Route::post('/movies', [PeliculaApiController::class, 'store']);
// Route::put('/movies/{id}', [PeliculaApiController::class, 'update']);
// Route::delete('/movies/{id}', [PeliculaApiController::class, 'destroy']);
