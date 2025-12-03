<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function ValidacionDatosUsuario(Request $request) {
         $validated = $request->validate([
             'name' => 'required|numeric',
            'email' => 'required|unique:users|email',
         
        ]);

        

    }
}
