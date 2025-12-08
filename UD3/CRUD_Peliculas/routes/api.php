<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PeliculaApiController;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas API con controlador documentado para Swagger
Route::get('/movies', [PeliculaApiController::class, 'index']);
Route::get('/movies/{id}', [PeliculaApiController::class, 'show']);
Route::post('/movies', [PeliculaApiController::class, 'store']);
Route::put('/movies/{id}', [PeliculaApiController::class, 'update']);
Route::delete('/movies/{id}', [PeliculaApiController::class, 'destroy']);
