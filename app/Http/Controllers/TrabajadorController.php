<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use App\Models\Finca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrabajadorController extends FincaBaseController
{
    public function index(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $trabajadores = Trabajador::with('finca')
                                  ->where('finca_id', $finca->id)
                                  ->get();

        return view('trabajadores.index', compact('finca', 'trabajadores'));
    }

    public function create(Finca $finca)
    {
        $this->verificarPropietario($finca);

        return view('trabajadores.create', compact('finca'));
    }

    public function store(Request $request, Finca $finca)
    {
        $this->verificarPropietario($finca);

        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'cedula'      => 'nullable|string|max:20',
            'telefono'    => 'nullable|string|max:20',
            'salario_dia' => 'required|numeric|min:0',
            'estado'      => 'nullable|boolean',
        ]);

        $validated['finca_id'] = $finca->id;

        Trabajador::create($validated);

        return redirect()->route('trabajadores.index', $finca)
                         ->with('success', 'Trabajador registrado exitosamente.');
    }

    public function edit(Finca $finca, $trabajadorId)
    {
      

        $trabajador = Trabajador::where('id', $trabajadorId)
                                ->where('finca_id', $finca->id)
                                ->firstOrFail();

        return view('trabajadores.edit', compact('finca', 'trabajador'));
    }

    public function update(Request $request, Finca $finca, $trabajadorId)
    {
        

        $trabajador = Trabajador::where('id', $trabajadorId)
                                ->where('finca_id', $finca->id)
                                ->firstOrFail();

        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'cedula'      => 'nullable|string|max:20',
            'telefono'    => 'nullable|string|max:20',
            'salario_dia' => 'required|numeric|min:0',
            'estado'      => 'nullable|boolean',
        ]);

        $trabajador->update($validated);

        return redirect()->route('trabajadores.index', $finca)
                         ->with('success', 'Trabajador actualizado exitosamente.');
    }

    public function destroy(Finca $finca, $trabajadorId)
    {
        $this->verificarPropietario($finca);

        $trabajador = Trabajador::where('id', $trabajadorId)
                                ->where('finca_id', $finca->id)
                                ->firstOrFail();

        $trabajador->delete();

        return redirect()->route('trabajadores.index', $finca)
                         ->with('success', 'Trabajador eliminado exitosamente.');
    }
}