<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;
use App\Models\Periodo;
use Illuminate\Validation\Rule;

class AutorControlador extends Controller
{
    // Validar datos del autor
    public function ValidarAutor(Request $request, $id = null)
    {
        $nombreRule = ['required', 'string', 'min:3', 'max:100'];

        if ($id == null) {
            $nombreRule[] = 'unique:autores,nombre';
        } else {
            $nombreRule[] = Rule::unique('autores', 'nombre')->ignore((int)$id, 'id');
        }

        $rules = [
            'nombre' => $nombreRule,
            'pais' => ['nullable', 'string', 'max:100'],
            'foto_url' => ['nullable', 'string', 'url', 'max:500'],
            'periodo' => ['nullable', 'string', Rule::in(Periodo::PERIODOS)],
        ];

        $request->validate($rules);
    }

    // Registrar un nuevo autor
    public function RegistrarAutor(Request $request)
    {
        $this->ValidarAutor($request);

        $data = $request->all();

        // Si no se proporciona foto_url, generar una por defecto
        if (empty($data['foto_url'])) {
            $nombreEncoded = urlencode($data['nombre']);
            $data['foto_url'] = "https://ui-avatars.com/api/?name={$nombreEncoded}&background=random&size=256";
        }

        // Obtener el periodo_id a partir del nombre del periodo
        $periodo_id = null;
        if (!empty($data['periodo'])) {
            $periodo = Periodo::where('nombre', $data['periodo'])->first();
            $periodo_id = $periodo?->id;
        }

        $autorNuevo = Autor::create([
            'nombre' => $data['nombre'],
            'pais' => $data['pais'],
            'foto_url' => $data['foto_url'],
            'periodo_id' => $periodo_id,
        ]);

        return redirect('/')->with('success', 'Autor creado exitosamente');
    }

    // Editar un autor existente
    public function editarAutor($id, Request $request)
    {
        $this->ValidarAutor($request, $id);

        $data = $request->all();
        $autor = Autor::findOrFail($id);

        // Si no se proporciona foto_url, generar una por defecto
        if (empty($data['foto_url'])) {
            $nombreEncoded = urlencode($data['nombre']);
            $data['foto_url'] = "https://ui-avatars.com/api/?name={$nombreEncoded}&background=random&size=256";
        }

        // Obtener el periodo_id a partir del nombre del periodo
        $periodo_id = null;
        if (!empty($data['periodo'])) {
            $periodo = Periodo::where('nombre', $data['periodo'])->first();
            $periodo_id = $periodo?->id;
        }

        $autor->nombre = $data['nombre'];
        $autor->pais = $data['pais'];
        $autor->foto_url = $data['foto_url'];
        $autor->periodo_id = $periodo_id;
        $autor->save();

        return redirect('/autor/detalle/' . $id)->with('success', 'Autor actualizado exitosamente');
    }
}
