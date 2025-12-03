<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function validarUsuario(Request $request, $id = 0)
    {
        $request->validate([
            "nombre" => ["required"],
            "email" => ["required", "email", Rule::unique("usuarios")->ignore($id)]
        ]);
    }

    public function insertarUsuario(Request $request)
    {

        $this->validarUsuario($request);

        $data = $request->all();

        $usuarioNuevo = Usuario::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
        ]);

        return view('detalle-usuario', ['usuario' => $usuarioNuevo]);

    }

    public function editarUsuario($id, Request $request)
    {

        $this->validarUsuario($request, $id);

        $data = $request->all();
        $usuario = Usuario::find($id);

        if($usuario){
            $usuario->nombre = $data['nombre'];
            $usuario->email = $data['email'];

            $usuario->save();
        }

        return view('detalle-usuario', ['usuario' => $usuario]);

    }
}
