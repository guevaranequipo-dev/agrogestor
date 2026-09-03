<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Finca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsumoController extends FincaBaseController
{
    public function index(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $insumos = Insumo::with('finca')
                         ->where('finca_id', $finca->id)
                         ->get();

        return view('insumos.index', compact('finca', 'insumos'));
    }

    public function create(Finca $finca)
    {
        $this->verificarPropietario($finca);

        return view('insumos.create', compact('finca'));
    }

    public function store(Request $request, Finca $finca)
    {
        $this->verificarPropietario($finca);

        $validated = $request->validate([
            'nombre'              => 'required|string|max:255',
            'tipo'                => 'required|in:fertilizante,abono,veneno,otro',
            'unidad_medida'       => 'required|string|max:50',
            'cantidad_disponible' => 'required|numeric|min:0',
            'precio_unitario'     => 'nullable|numeric|min:0',
            'descripcion'         => 'nullable|string',
        ]);

        $validated['finca_id'] = $finca->id;

        Insumo::create($validated);

        return redirect()->route('insumos.index', $finca)
                         ->with('success', 'Insumo registrado exitosamente.');
    }

    public function edit(Finca $finca, $insumoId)
    {
        $this->verificarPropietario($finca);

        $insumo = Insumo::where('id', $insumoId)
                        ->where('finca_id', $finca->id)
                        ->firstOrFail();

        return view('insumos.edit', compact('finca', 'insumo'));
    }

    public function update(Request $request, Finca $finca, $insumoId)
    {
        $this->verificarPropietario($finca);

        $insumo = Insumo::where('id', $insumoId)
                        ->where('finca_id', $finca->id)
                        ->firstOrFail();

        $validated = $request->validate([
            'nombre'              => 'required|string|max:255',
            'tipo'                => 'required|in:fertilizante,abono,veneno,otro',
            'unidad_medida'       => 'required|string|max:50',
            'cantidad_disponible' => 'required|numeric|min:0',
            'precio_unitario'     => 'nullable|numeric|min:0',
            'descripcion'         => 'nullable|string',
        ]);

        $insumo->update($validated);

        return redirect()->route('insumos.index', $finca)
                         ->with('success', 'Insumo actualizado exitosamente.');
    }

    public function destroy(Finca $finca, $insumoId)
    {
        $this->verificarPropietario($finca);

        $insumo = Insumo::where('id', $insumoId)
                        ->where('finca_id', $finca->id)
                        ->firstOrFail();

        $insumo->delete();

        return redirect()->route('insumos.index', $finca)
                         ->with('success', 'Insumo eliminado exitosamente.');
    }
}