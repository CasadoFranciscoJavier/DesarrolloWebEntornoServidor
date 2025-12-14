<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;
use Illuminate\Validation\Rule;

class JuegoControlador extends Controller
{
    public function ValidarJuego(Request $request, $id = null)
    {
        $generosList = implode(',', Juego::VALID_GENEROS);

        $tituloRule = ['required', 'string', 'min:3', 'max:50'];

         if ($id == null) {
            $tituloRule[] = 'unique:juegos,titulo';
        } else {
            $tituloRule[] = Rule::unique('juegos', 'titulo')->ignore((int)$id, 'id');
        }

        $rules = [
            'titulo' => $tituloRule,
            'anio' => ['required', 'integer', 'min:1000', 'max:' . (date('Y') + 10)],
            'genero' => ['required', 'string', 'in:' . $generosList],
            'cover_url' => ['nullable', 'string', 'url', 'max:255'],     

            'compania_id' => ['required', 'integer', 'exists:companias,id'],
        ];

        $request->validate($rules);
    }

    public function RegistrarJuego(Request $request)
    {
        $this->ValidarJuego($request);

        $data = $request->all();

        if (empty($data['cover_url'])) {
            $tituloEncoded = urlencode($data['titulo']);
            $data['cover_url'] = "https://ui-avatars.com/api/?name={$tituloEncoded}&background=random&size=256";
        }

        $juegoNuevo = Juego::create([
            'titulo' => $data['titulo'],
            'anio' => $data['anio'],
            'genero' => $data['genero'],
            'cover_url' => $data['cover_url'],         
            'compania_id' => $data['compania_id'],
        ]);

        return $juegoNuevo;
    }
}
