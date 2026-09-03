<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Finca;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends FincaBaseController
{
    public function index(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $pagos = Pago::with('trabajador')
                     ->where('finca_id', $finca->id)
                     ->orderBy('fecha', 'desc')
                     ->get();

        return view('pagos.index', compact('finca', 'pagos'));
    }

    public function create(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $trabajadores = Trabajador::where('finca_id', $finca->id)
                                  ->where('estado', true)
                                  ->get();

        return view('pagos.create', compact('finca', 'trabajadores'));
    }

    public function store(Request $request, Finca $finca)
    {
        $this->verificarPropietario($finca);

        $validated = $request->validate([
            'trabajador_id'        => 'required|exists:trabajadores,id',
            'tipo_pago'            => 'required|in:jornal,contrato,recoleccion',
            'fecha'                => 'required|date',
            'dias_trabajados'      => 'required_if:tipo_pago,jornal|nullable|integer|min:1',
            'valor_dia'            => 'required_if:tipo_pago,jornal|nullable|numeric|min:0',
            'descripcion_contrato' => 'required_if:tipo_pago,contrato|nullable|string',
            'valor_contrato'       => 'required_if:tipo_pago,contrato|nullable|numeric|min:0',
            'cantidad_recolectada' => 'required_if:tipo_pago,recoleccion|nullable|numeric|min:0',
            'precio_por_kg'        => 'required_if:tipo_pago,recoleccion|nullable|numeric|min:0',
        ]);

        $validated['finca_id'] = $finca->id;
        $validated['total'] = Pago::calcularTotal($validated['tipo_pago'], $validated);

        $pago = Pago::create($validated);
        $pago->sincronizarGasto();

        return redirect()->route('pagos.index', $finca)
                         ->with('success', 'Pago registrado exitosamente.');
    }

    public function edit(Finca $finca, $pagoId)
    {
        $this->verificarPropietario($finca);

        $pago = Pago::where('id', $pagoId)
                    ->where('finca_id', $finca->id)
                    ->firstOrFail();

        $trabajadores = Trabajador::where('finca_id', $finca->id)
                                  ->where('estado', true)
                                  ->get();

        return view('pagos.edit', compact('finca', 'pago', 'trabajadores'));
    }

    public function update(Request $request, Finca $finca, $pagoId)
    {
        $this->verificarPropietario($finca);

        $pago = Pago::where('id', $pagoId)
                    ->where('finca_id', $finca->id)
                    ->firstOrFail();

        $validated = $request->validate([
            'trabajador_id'        => 'required|exists:trabajadores,id',
            'tipo_pago'            => 'required|in:jornal,contrato,recoleccion',
            'fecha'                => 'required|date',
            'dias_trabajados'      => 'required_if:tipo_pago,jornal|nullable|integer|min:1',
            'valor_dia'            => 'required_if:tipo_pago,jornal|nullable|numeric|min:0',
            'descripcion_contrato' => 'required_if:tipo_pago,contrato|nullable|string',
            'valor_contrato'       => 'required_if:tipo_pago,contrato|nullable|numeric|min:0',
            'cantidad_recolectada' => 'required_if:tipo_pago,recoleccion|nullable|numeric|min:0',
            'precio_por_kg'        => 'required_if:tipo_pago,recoleccion|nullable|numeric|min:0',
        ]);

        $validated['total'] = Pago::calcularTotal($validated['tipo_pago'], $validated);

        $pago->update($validated);
        $pago->sincronizarGasto();

        return redirect()->route('pagos.index', $finca)
                         ->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(Finca $finca, $pagoId)
    {
        $this->verificarPropietario($finca);

        $pago = Pago::where('id', $pagoId)
                    ->where('finca_id', $finca->id)
                    ->firstOrFail();

        $pago->eliminarGasto();
        $pago->delete();

        return redirect()->route('pagos.index', $finca)
                         ->with('success', 'Pago eliminado exitosamente.');
    }
}
