<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FincaController extends FincaBaseController
{
    // Listar todas las fincas del usuario autenticado
    public function index()
    {
        $fincas = Finca::where('user_id', Auth::id())->get();
        return view('fincas.index', compact('fincas'));
    }

    public function show(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $totalTrabajadores = $finca->trabajadores()->count();
        $trabajadoresActivos = $finca->trabajadores()->where('estado', true)->count();

        $actividadesPendientes = $finca->actividades()->where('estado', 'pendiente')->count();
        $actividadesEnProgreso = $finca->actividades()->where('estado', 'en_progreso')->count();

        $totalIngresos = $finca->ingresos()->sum('monto');
        $totalGastos = $finca->gastos()->sum('monto');
        $balance = $totalIngresos - $totalGastos;

        $totalPagado = $finca->pagos()->sum('total');

        $proximasActividades = $finca->actividades()
                                    ->where('estado', '!=', 'completada')
                                    ->where('fecha_programada', '>=', now())
                                    ->orderBy('fecha_programada')
                                    ->take(3)
                                    ->get();

        return view('fincas.show', compact(
            'finca',
            'totalTrabajadores',
            'trabajadoresActivos',
            'actividadesPendientes',
            'actividadesEnProgreso',
            'totalIngresos',
            'totalGastos',
            'balance',
            'totalPagado',
            'proximasActividades'
        ));
    }

    // Mostrar formulario para crear una finca
    public function create()
    {
        return view('fincas.create');
    }

    // Guardar una nueva finca
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'hectareas' => 'nullable|numeric',
            'descripcion' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        Finca::create($validated);

        return redirect()->route('fincas.index')
                         ->with('success', 'Finca creada exitosamente.');
    }

    // Mostrar formulario para editar una finca
    public function edit(Finca $finca)
    {
        // Verificar que la finca pertenece al usuario autenticado
        $this->verificarPropietario($finca);
        return view('fincas.edit', compact('finca'));
    }

    // Actualizar una finca
    public function update(Request $request, Finca $finca)
    {
        $this->verificarPropietario($finca);
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'ubicacion'   => 'nullable|string|max:255',
            'hectareas'   => 'nullable|numeric',
            'descripcion' => 'nullable|string',
        ]);

        $finca->update($validated);
        return redirect()->route('fincas.index')
                         ->with('success', 'Finca actualizada exitosamente.');
    }

    // Eliminar una finca
    public function destroy(Finca $finca)
    {
        $this->verificarPropietario($finca);
        $finca->delete();
        return redirect()->route('fincas.index')
                         ->with('success', 'Finca eliminada exitosamente.');
    }
}