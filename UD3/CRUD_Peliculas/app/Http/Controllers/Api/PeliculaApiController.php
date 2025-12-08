<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\peliculaControlador;
use App\Models\Pelicula;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PeliculaApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/movies",
     *     tags={"Películas"},
     *     summary="Listar todas las películas",
     *     description="Obtiene la lista completa de películas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de películas obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="poster_url", type="string", example="https://image.tmdb.org/t/p/w500/poster.jpg"),
     *                 @OA\Property(property="title", type="string", example="The Matrix"),
     *                 @OA\Property(property="release_year", type="integer", example=1999),
     *                 @OA\Property(property="genres", type="array", @OA\Items(type="string"), example={"Sci-Fi", "Action"}),
     *                 @OA\Property(property="synopsis", type="string", example="Un hacker descubre la verdad sobre su realidad..."),
     *                 @OA\Property(property="created_at", type="string", format="datetime"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $peliculas = Pelicula::all();
        return $peliculas;
    }

    /**
     * @OA\Get(
     *     path="/api/movies/{id}",
     *     tags={"Películas"},
     *     summary="Obtener detalle de una película",
     *     description="Obtiene los detalles de una película específica junto con sus comentarios",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Película y comentarios obtenidos exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 oneOf={
     *                     @OA\Schema(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="poster_url", type="string"),
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="release_year", type="integer"),
     *                         @OA\Property(property="genres", type="array", @OA\Items(type="string")),
     *                         @OA\Property(property="synopsis", type="string")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $pelicula = Pelicula::find($id);
        $comentarios = Comentario::where('pelicula_id', $id)->orderBy('created_at', 'desc')->get();
        return [$pelicula, $comentarios];
    }

    /**
     * @OA\Post(
     *     path="/api/movies",
     *     tags={"Películas"},
     *     summary="Crear una nueva película",
     *     description="Crea una nueva película en la base de datos",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"poster_url", "title", "release_year", "genres", "synopsis"},
     *             @OA\Property(property="poster_url", type="string", example="https://image.tmdb.org/t/p/w500/poster.jpg"),
     *             @OA\Property(property="title", type="string", example="Inception"),
     *             @OA\Property(property="release_year", type="integer", example=2010),
     *             @OA\Property(property="genres", type="array", @OA\Items(type="string"), example={"Sci-Fi", "Action"}),
     *             @OA\Property(property="synopsis", type="string", example="Un ladrón que roba secretos corporativos...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Película creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=21),
     *             @OA\Property(property="poster_url", type="string"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="release_year", type="integer"),
     *             @OA\Property(property="genres", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="synopsis", type="string"),
     *             @OA\Property(property="created_at", type="string", format="datetime"),
     *             @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="array", @OA\Items(type="string"), example={"The title has already been taken."})
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $controlador = new peliculaControlador();

        try {
            $respuesta = $controlador->RegistrarPelicula($request);
        } catch (ValidationException $e) {
            $respuesta = $e->errors();
        }

        return $respuesta;
    }

    /**
     * @OA\Put(
     *     path="/api/movies/{id}",
     *     tags={"Películas"},
     *     summary="Actualizar una película",
     *     description="Actualiza los datos de una película existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"poster_url", "title", "release_year", "genres", "synopsis"},
     *             @OA\Property(property="poster_url", type="string", example="https://image.tmdb.org/t/p/w500/poster.jpg"),
     *             @OA\Property(property="title", type="string", example="Inception"),
     *             @OA\Property(property="release_year", type="integer", example=2010),
     *             @OA\Property(property="genres", type="array", @OA\Items(type="string"), example={"Sci-Fi", "Action", "Drama"}),
     *             @OA\Property(property="synopsis", type="string", example="Sinopsis actualizada...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Película actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=2),
     *             @OA\Property(property="poster_url", type="string"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="release_year", type="integer"),
     *             @OA\Property(property="genres", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="synopsis", type="string"),
     *             @OA\Property(property="created_at", type="string", format="datetime"),
     *             @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function update($id, Request $request)
    {
        $controlador = new peliculaControlador();

        try {
            $respuesta = $controlador->editarPelicula($id, $request);
        } catch (ValidationException $e) {
            $respuesta = $e->errors();
        }

        return $respuesta;
    }

    /**
     * @OA\Delete(
     *     path="/api/movies/{id}",
     *     tags={"Películas"},
     *     summary="Eliminar una película",
     *     description="Elimina una película de la base de datos",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="Película eliminada correctamente")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="error", type="string", example="Película no encontrada")
     *                 )
     *             }
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $pelicula = Pelicula::find($id);

        if ($pelicula) {
            $pelicula->delete();
            return ['message' => 'Película eliminada correctamente'];
        }

        return ['error' => 'Película no encontrada'];
    }
}
