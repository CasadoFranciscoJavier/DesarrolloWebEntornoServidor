<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obra;
use App\Models\Tipo;
use Illuminate\Validation\Rule;

class ObraControlador extends Controller
{
    // Validar datos de la obra
    public function ValidarObra(Request $request)
    {
        $rules = [
            'titulo' => ['required', 'string', 'min:3', 'max:200'],
            'anio' => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 10)],
            'autor_id' => ['required', 'integer', 'exists:autores,id'],
            'tipo' => ['nullable', 'string', Rule::in(Tipo::TIPOS)],
        ];

        $request->validate($rules);
    }

    // Registrar una nueva obra
    public function RegistrarObra(Request $request)
    {
        $this->ValidarObra($request);

        $data = $request->all();

        // Obtener el tipo_id a partir del nombre del tipo
        $tipo_id = null;
        if (!empty($data['tipo'])) {
            $tipo = Tipo::where('nombre', $data['tipo'])->first();
            $tipo_id = $tipo?->id;
        }

        $obraNueva = Obra::create([
            'titulo' => $data['titulo'],
            'anio' => $data['anio'],
            'autor_id' => $data['autor_id'],
            'tipo_id' => $tipo_id,
        ]);

        return redirect('/autor/detalle/' . $data['autor_id'])->with('success', 'Obra creada exitosamente');
    }
}
