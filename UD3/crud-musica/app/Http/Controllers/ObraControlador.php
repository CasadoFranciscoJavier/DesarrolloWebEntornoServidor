<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obra;
use Illuminate\Validation\Rule;

class ObraControlador extends Controller
{
    public function ValidarObra(Request $request)
    {
        $tiposList = implode(',', Obra::VALID_TIPOS);

        $rules = [
            'titulo' => ['required', 'string', 'min:3', 'max:200'],
            'tipo' => ['nullable', 'string', 'in:' . $tiposList],
            'anio' => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 10)],
            'autor_id' => ['required', 'integer', 'exists:autores,id'],
        ];

        $request->validate($rules);
    }

    public function RegistrarObra(Request $request)
    {
        $this->ValidarObra($request);

        $data = $request->all();

        $obraNueva = Obra::create([
            'titulo' => $data['titulo'],
            'tipo' => $data['tipo'],
            'anio' => $data['anio'],
            'autor_id' => $data['autor_id'],
        ]);

        return $obraNueva;
    }
}
