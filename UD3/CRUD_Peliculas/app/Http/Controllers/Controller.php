<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="API CRUD Películas",
 *     version="1.0.0",
 *     description="API REST para gestión de películas con Laravel",
 *     @OA\Contact(
 *         email="admin@crudpeliculas.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Servidor de desarrollo local"
 * )
 *
 * @OA\Tag(
 *     name="Películas",
 *     description="Operaciones CRUD de películas"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
