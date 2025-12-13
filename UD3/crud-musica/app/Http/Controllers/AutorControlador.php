<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;
use Illuminate\Validation\Rule;

class AutorControlador extends Controller
{
     public function ValidarAutor(Request $request, $id = null)
    {
        $periodosList = implode(',', Autor::VALID_PERIODOS);

        $nombreRule = ['required', 'string', 'min:3', 'max:100'];

        if ($id == null) {
            $nombreRule[] = 'unique:autores,nombre';
        } else {
            $nombreRule[] = Rule::unique('autores', 'nombre')->ignore((int)$id, 'id');
        }

          $rules = [
            'nombre' => $nombreRule,
            'pais' => ['nullable', 'string', 'max:100'],
            'periodo' => ['nullable', 'string', 'in:' . $periodosList],
            'foto_url' => ['nullable', 'string', 'url', 'max:255'],
        ];

   

        $request->validate($rules);


    }

    public function RegistrarAutor(Request $request)
    {
        $this->ValidarAutor($request);

        $data = $request->all();

        // Si no se proporciona foto_url, generar una por defecto
        if (empty($data['foto_url'])) {
            $nombreEncoded = urlencode($data['nombre']);
            $data['foto_url'] = "https://ui-avatars.com/api/?name={$nombreEncoded}&background=random&size=256";
        }

        $autorNuevo = Autor::create([
            'foto_url' => $data['foto_url'],
            'nombre' => $data['nombre'],
            'pais' => $data['pais'],
            'periodo' => $data['periodo'],
        ]);

        return $autorNuevo;
    }

     public function editarAutor($id, Request $request)
    {

        $this->ValidarAutor($request, $id);

        $data = $request->all();
        $autor = Autor::find($id);

        if (empty($data['foto_url'])) {
            $nombreEncoded = urlencode($data['nombre']);
            $data['foto_url'] = "https://ui-avatars.com/api/?name={$nombreEncoded}&background=random&size=256";
        }


        if($autor){
            $autor->foto_url = $data['foto_url'];
            $autor->nombre = $data['nombre'];
            $autor->pais = $data['pais'];
            $autor->periodo = $data['periodo'];
    
            $autor->save();
        }

        return $autor;

    }
}
