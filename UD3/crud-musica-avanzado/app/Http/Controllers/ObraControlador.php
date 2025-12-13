<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obra;
use App\Models\Tipo;

class ObraControlador extends Controller
{
    // Registrar una nueva obra con sus tipos
    public function registrarObra(Request $request)
    {
        try {
            // Validar los datos
            $request->validate([
                'titulo' => 'required|string|max:255',
                'anio' => 'nullable|integer|min:1000|max:' . (date('Y') + 10),
                'autor_id' => 'required|exists:autores,id',
                'tipos' => 'required|array|min:1',
                'tipos.*' => 'string|exists:tipos,nombre',
            ]);

            // Crear la obra
            $obra = Obra::create([
                'titulo' => $request->titulo,
                'anio' => $request->anio,
                'autor_id' => $request->autor_id,
            ]);

            // Obtener los IDs de los tipos desde sus nombres
            $tiposIDs = Tipo::whereIn('nombre', $request->tipos)->pluck('id');

            // ATTACH: Vincular los tipos a la obra
            $obra->tipos()->attach($tiposIDs);

            // Cargar las relaciones
            $obra->load('tipos');

            return redirect('/autor/detalle/' . $request->autor_id)->with('success', 'Obra creada exitosamente');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la obra: ' . $e->getMessage()])->withInput();
        }
    }
}
