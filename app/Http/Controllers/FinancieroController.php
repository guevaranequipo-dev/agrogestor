<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Gasto;
use App\Models\Finca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancieroController extends FincaBaseController
{
    //      VISTA PRINCIPAL 
    public function index(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $ingresos = Ingreso::where('finca_id', $finca->id)->orderBy('fecha', 'desc')->get();
        $gastos = Gasto::where('finca_id', $finca->id)->orderBy('fecha', 'desc')->get();

        $totalIngresos = $ingresos->sum('monto');
        $totalGastos = $gastos->sum('monto');
        $balance = $totalIngresos - $totalGastos;

        return view('financiero.index', compact('finca', 'ingresos', 'gastos', 'totalIngresos', 'totalGastos', 'balance'));
    }

    //        INGRESOS 
    public function createIngreso(Finca $finca)
    {
        $this->verificarPropietario($finca);
        return view('financiero.create_ingreso', compact('finca'));
    }

    public function storeIngreso(Request $request, Finca $finca)
    {
        $this->verificarPropietario($finca);

        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto'       => 'required|numeric|min:0',
            'categoria'   => 'nullable|string|max:100',
            'fecha'       => 'required|date',
        ]);

        $validated['finca_id'] = $finca->id;

        Ingreso::create($validated);

        return redirect()->route('financiero.index', $finca)
                         ->with('success', 'Ingreso registrado exitosamente.');
    }

    public function editIngreso(Finca $finca, $ingresoId)
    {
        $this->verificarPropietario($finca);

        $ingreso = Ingreso::where('id', $ingresoId)
                          ->where('finca_id', $finca->id)
                          ->firstOrFail();

        return view('financiero.edit_ingreso', compact('finca', 'ingreso'));
    }

    public function updateIngreso(Request $request, Finca $finca, $ingresoId)
    {
        $this->verificarPropietario($finca);

        $ingreso = Ingreso::where('id', $ingresoId)
                          ->where('finca_id', $finca->id)
                          ->firstOrFail();

        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto'       => 'required|numeric|min:0',
            'categoria'   => 'nullable|string|max:100',
            'fecha'       => 'required|date',
        ]);

        $ingreso->update($validated);

        return redirect()->route('financiero.index', $finca)
                         ->with('success', 'Ingreso actualizado exitosamente.');
    }

    public function destroyIngreso(Finca $finca, $ingresoId)
    {
        $this->verificarPropietario($finca);

        $ingreso = Ingreso::where('id', $ingresoId)
                          ->where('finca_id', $finca->id)
                          ->firstOrFail();

        $ingreso->delete();

        return redirect()->route('financiero.index', $finca)
                         ->with('success', 'Ingreso eliminado exitosamente.');
    }

    //        GASTOS
    public function createGasto(Finca $finca)
    {
        $this->verificarPropietario($finca);
        return view('financiero.create_gasto', compact('finca'));
    }

    public function storeGasto(Request $request, Finca $finca)
    {
        $this->verificarPropietario($finca);

        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto'       => 'required|numeric|min:0',
            'categoria'   => 'nullable|string|max:100',
            'fecha'       => 'required|date',
        ]);

        $validated['finca_id'] = $finca->id;

        Gasto::create($validated);

        return redirect()->route('financiero.index', $finca)
                         ->with('success', 'Gasto registrado exitosamente.');
    }

    public function editGasto(Finca $finca, $gastoId)
    {
        $this->verificarPropietario($finca);

        $gasto = Gasto::where('id', $gastoId)
                      ->where('finca_id', $finca->id)
                      ->firstOrFail();

        return view('financiero.edit_gasto', compact('finca', 'gasto'));
    }

    public function updateGasto(Request $request, Finca $finca, $gastoId)
    {
        $this->verificarPropietario($finca);

        $gasto = Gasto::where('id', $gastoId)
                      ->where('finca_id', $finca->id)
                      ->firstOrFail();

        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto'       => 'required|numeric|min:0',
            'categoria'   => 'nullable|string|max:100',
            'fecha'       => 'required|date',
        ]);

        $gasto->update($validated);

        return redirect()->route('financiero.index', $finca)
                         ->with('success', 'Gasto actualizado exitosamente.');
    }

    public function destroyGasto(Finca $finca, $gastoId)
    {
        $this->verificarPropietario($finca);

        $gasto = Gasto::where('id', $gastoId)
                      ->where('finca_id', $finca->id)
                      ->firstOrFail();

        $gasto->delete();

        return redirect()->route('financiero.index', $finca)
                         ->with('success', 'Gasto eliminado exitosamente.');
    }
}