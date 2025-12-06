<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Pelicula;

class ComentarioControlador extends Controller
{
    public function ValidarComentario(Request $request)
    {
        $rules = [
            'pelicula_id' => ['required', 'integer', 'exists:peliculas,id'],
            'content' => ['required', 'string', 'min:3', 'max:1000'],
        ];

       $request->validate($rules);
    }

    public function RegistrarComentario(Request $request)
    {
        $this->ValidarComentario($request);

        $data = $request->all();

        $comentarioNuevo = Comentario::create([
            'user_id' => auth()->id(),
            'pelicula_id' => $data['pelicula_id'],
            'content' => $data['content'],
        ]);

        return $comentarioNuevo;
    }
}
