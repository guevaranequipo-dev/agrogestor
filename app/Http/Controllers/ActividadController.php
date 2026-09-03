<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Finca;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActividadController extends FincaBaseController
{
    public function index(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $actividades = Actividad::with(['finca', 'trabajadores'])
                                ->where('finca_id', $finca->id)
                                ->get();

        return view('actividades.index', compact('finca', 'actividades'));
    }

    public function create(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $trabajadores = Trabajador::where('finca_id', $finca->id)->get();

        return view('actividades.create', compact('finca', 'trabajadores'));
    }

    public function store(Request $request, Finca $finca)
    {
        $this->verificarPropietario($finca);

        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'fecha_programada' => 'required|date',
            'estado'           => 'required|in:pendiente,en_progreso,completada',
            'trabajadores'     => 'nullable|array',
            'trabajadores.*'   => 'exists:trabajadores,id',
        ]);

        $validated['finca_id'] = $finca->id;

        $actividad = Actividad::create([
            'finca_id'         => $validated['finca_id'],
            'nombre'           => $validated['nombre'],
            'descripcion'      => $validated['descripcion'] ?? null,
            'fecha_programada' => $validated['fecha_programada'],
            'estado'           => $validated['estado'],
        ]);

        if (!empty($validated['trabajadores'])) {
            $actividad->trabajadores()->sync($validated['trabajadores']);
        }

        return redirect()->route('actividades.index', $finca)
                         ->with('success', 'Actividad creada exitosamente.');
    }

    public function edit(Finca $finca, $actividadId)
    {
        $this->verificarPropietario($finca);

        $actividad = Actividad::where('id', $actividadId)
                              ->where('finca_id', $finca->id)
                              ->firstOrFail();

        $trabajadores = Trabajador::where('finca_id', $finca->id)->get();
        $trabajadoresAsignados = $actividad->trabajadores->pluck('id')->toArray();

        return view('actividades.edit', compact('finca', 'actividad', 'trabajadores', 'trabajadoresAsignados'));
    }

    public function update(Request $request, Finca $finca, $actividadId)
    {
        $this->verificarPropietario($finca);

        $actividad = Actividad::where('id', $actividadId)
                              ->where('finca_id', $finca->id)
                              ->firstOrFail();

        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'fecha_programada' => 'required|date',
            'estado'           => 'required|in:pendiente,en_progreso,completada',
            'trabajadores'     => 'nullable|array',
            'trabajadores.*'   => 'exists:trabajadores,id',
        ]);

        $actividad->update([
            'nombre'           => $validated['nombre'],
            'descripcion'      => $validated['descripcion'] ?? null,
            'fecha_programada' => $validated['fecha_programada'],
            'estado'           => $validated['estado'],
        ]);

        if (!empty($validated['trabajadores'])) {
            $actividad->trabajadores()->sync($validated['trabajadores']);
        } else {
            $actividad->trabajadores()->detach();
        }

        return redirect()->route('actividades.index', $finca)
                         ->with('success', 'Actividad actualizada exitosamente.');
    }

    public function destroy(Finca $finca, $actividadId)
    {
        $this->verificarPropietario($finca);

        $actividad = Actividad::where('id', $actividadId)
                              ->where('finca_id', $finca->id)
                              ->firstOrFail();

        $actividad->delete();

        return redirect()->route('actividades.index', $finca)
                         ->with('success', 'Actividad eliminada exitosamente.');
    }
}