<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compania;
use Illuminate\Validation\Rule;

class CompaniaControlador extends Controller
{
     public function ValidarCompania(Request $request, $id = null)
    {
        $tipoList = implode(',', Compania::VALID_TIPOS);

        $nombreRule = ['required', 'string', 'min:3', 'max:50'];

        if ($id == null) {
            $nombreRule[] = 'unique:companias,nombre';
        } else {
            $nombreRule[] = Rule::unique('companias', 'nombre')->ignore((int)$id, 'id');
        }

          $rules = [
            'nombre' => $nombreRule,
            'pais' => ['required', 'string', 'max:50'],
            'tipo' => ['required', 'string', 'in:' . $tipoList],
           
        ];

   

        $request->validate($rules);


    }

    public function RegistrarCompania(Request $request)
    {
        $this->ValidarCompania($request);

        $data = $request->all();

        // if (empty($data['foto_url'])) {
        //     $nombreEncoded = urlencode($data['nombre']);
        //     $data['foto_url'] = "https://ui-avatars.com/api/?name={$nombreEncoded}&background=random&size=256";
        // }

        $companiaNueva = Compania::create([
           
            'nombre' => $data['nombre'],
            'pais' => $data['pais'],
            'tipo' => $data['tipo'],
        ]);

        return $companiaNueva;
    }

     public function editarCompania($id, Request $request)
    {

        $this->ValidarCompania($request, $id);

        $data = $request->all();
        $compania = Compania::find($id);



        if($compania){
            
            $compania->nombre = $data['nombre'];
            $compania->pais = $data['pais'];
            $compania->tipo = $data['tipo'];
    
            $compania->save();
        }

        return $compania;

    }
}
