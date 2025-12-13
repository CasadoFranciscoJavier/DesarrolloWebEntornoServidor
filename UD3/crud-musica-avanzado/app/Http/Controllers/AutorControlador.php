<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;
use App\Models\Periodo;

class AutorControlador extends Controller
{
    // Registrar un nuevo autor con sus periodos
    public function registrarAutor(Request $request)
    {
        try {
            // Validar los datos
            $request->validate([
                'nombre' => 'required|string|max:255',
                'pais' => 'nullable|string|max:255',
                'foto_url' => 'nullable|url|max:500',
                'periodos' => 'required|array|min:1',
                'periodos.*' => 'string|exists:periodos,nombre',
            ]);

            // Crear el autor
            $autor = Autor::create([
                'nombre' => $request->nombre,
                'pais' => $request->pais,
                'foto_url' => $request->foto_url,
            ]);

            // Obtener los IDs de los periodos desde sus nombres
            $periodosIDs = Periodo::whereIn('nombre', $request->periodos)->pluck('id');

            // ATTACH: Vincular los periodos al autor
            $autor->periodos()->attach($periodosIDs);

            // Cargar las relaciones antes de devolver
            $autor->load('periodos');

            return redirect('/')->with('success', 'Autor creado exitosamente');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear el autor: ' . $e->getMessage()])->withInput();
        }
    }

    // Editar un autor existente
    public function editarAutor(Request $request, $id)
    {
        try {
            // Validar los datos
            $request->validate([
                'nombre' => 'required|string|max:255',
                'pais' => 'nullable|string|max:255',
                'foto_url' => 'nullable|url|max:500',
                'periodos' => 'required|array|min:1',
                'periodos.*' => 'string|exists:periodos,nombre',
            ]);

            // Buscar el autor
            $autor = Autor::findOrFail($id);

            // Actualizar el autor
            $autor->update([
                'nombre' => $request->nombre,
                'pais' => $request->pais,
                'foto_url' => $request->foto_url,
            ]);

            // Obtener los IDs de los periodos
            $periodosIDs = Periodo::whereIn('nombre', $request->periodos)->pluck('id');

            // SYNC: Reemplazar completamente los periodos anteriores
            $autor->periodos()->sync($periodosIDs);

            // Recargar las relaciones
            $autor->load('periodos');

            return redirect('/autor/detalle/' . $id)->with('success', 'Autor actualizado exitosamente');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al editar el autor: ' . $e->getMessage()])->withInput();
        }
    }
}
