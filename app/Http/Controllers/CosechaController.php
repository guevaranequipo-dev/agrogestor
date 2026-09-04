<?php

namespace App\Http\Controllers;

use App\Models\SemanaCosecha;
use App\Models\RegistroCosecha;
use App\Models\Finca;
use App\Models\Trabajador;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CosechaController extends FincaBaseController
{
    // ===== SEMANAS =====
    public function index(Finca $finca)
    {
        $this->verificarPropietario($finca);

        $semanas = SemanaCosecha::where('finca_id', $finca->id)
                                ->orderBy('fecha_inicio', 'desc')
                                ->get();

        return view('cosecha.index', compact('finca', 'semanas'));
    }

    public function create(Finca $finca)
    {
        $this->verificarPropietario($finca);

        // Calcular automáticamente el lunes y domingo de la semana actual
        $lunes = Carbon::now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $domingo = Carbon::now()->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        return view('cosecha.create', compact('finca', 'lunes', 'domingo'));
    }

    public function store(Request $request, Finca $finca)
    {
        $this->verificarPropietario($finca);

        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'precio_kilo'  => 'required|numeric|min:0',
        ]);

        $validated['finca_id'] = $finca->id;

        SemanaCosecha::create($validated);

        return redirect()->route('cosecha.index', $finca)
                         ->with('success', 'Semana de cosecha creada exitosamente.');
    }

    // ===== DETALLE DE SEMANA =====
    public function show(Finca $finca, $semanaId)
    {
        $this->verificarPropietario($finca);

        $semana = SemanaCosecha::where('id', $semanaId)
                               ->where('finca_id', $finca->id)
                               ->firstOrFail();

        $trabajadores = Trabajador::where('finca_id', $finca->id)
                                  ->where('estado', true)
                                  ->get();

        // Generar los días de la semana
        $dias = [];
        $inicio = Carbon::parse($semana->fecha_inicio);
        $fin = Carbon::parse($semana->fecha_fin);

        for ($dia = $inicio->copy(); $dia->lte($fin); $dia->addDay()) {
            $dias[] = $dia->copy();
        }

        // Obtener registros existentes
        $registros = RegistroCosecha::where('semana_id', $semana->id)
                                    ->get()
                                    ->groupBy(function($r) {
                                        return $r->trabajador_id . '_' . $r->fecha;
                                    });

        // Resumen por trabajador
        $resumenTrabajadores = RegistroCosecha::where('semana_id', $semana->id)
                                              ->with('trabajador')
                                              ->selectRaw('trabajador_id, SUM(total_kilos) as total_kilos')
                                              ->groupBy('trabajador_id')
                                              ->get();

        return view('cosecha.show', compact(
            'finca', 'semana', 'trabajadores', 'dias', 'registros', 'resumenTrabajadores'
        ));
    }

    // ===== AGREGAR TRABAJADOR A SEMANA =====
    public function agregarTrabajador(Request $request, Finca $finca, $semanaId)
    {
        $this->verificarPropietario($finca);

        $semana = SemanaCosecha::where('id', $semanaId)
                               ->where('finca_id', $finca->id)
                               ->firstOrFail();

        $validated = $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
        ]);

        // Crear registros vacíos para cada día de la semana
        $inicio = Carbon::parse($semana->fecha_inicio);
        $fin = Carbon::parse($semana->fecha_fin);

        for ($dia = $inicio->copy(); $dia->lte($fin); $dia->addDay()) {
            RegistroCosecha::firstOrCreate([
                'semana_id'     => $semana->id,
                'trabajador_id' => $validated['trabajador_id'],
                'fecha'         => $dia->format('Y-m-d'),
            ], [
                'kilos_manana' => 0,
                'kilos_tarde'  => 0,
                'total_kilos'  => 0,
            ]);
        }

        return redirect()->route('cosecha.show', [$finca, $semana])
                         ->with('success', 'Trabajador agregado a la semana exitosamente.');
    }

    // ===== GUARDAR REGISTROS DE KILOS =====
    public function guardarRegistros(Request $request, Finca $finca, $semanaId)
    {
        $this->verificarPropietario($finca);

        $semana = SemanaCosecha::where('id', $semanaId)
                               ->where('finca_id', $finca->id)
                               ->firstOrFail();

        if ($semana->estado === 'cerrada') {
            return redirect()->back()->with('error', 'Esta semana ya está cerrada.');
        }

        $registros = $request->input('registros', []);

        foreach ($registros as $registroId => $datos) {
            $registro = RegistroCosecha::where('id', $registroId)
                                       ->where('semana_id', $semana->id)
                                       ->first();

            if ($registro) {
                $kilosManana = floatval($datos['kilos_manana'] ?? 0);
                $kilosTarde  = floatval($datos['kilos_tarde'] ?? 0);
                $totalKilos  = RegistroCosecha::calcularTotal($kilosManana, $kilosTarde);

                $registro->update([
                    'kilos_manana' => $kilosManana,
                    'kilos_tarde'  => $kilosTarde,
                    'total_kilos'  => $totalKilos,
                ]);
            }
        }

        return redirect()->route('cosecha.show', [$finca, $semana])
                         ->with('success', 'Registros guardados exitosamente.');
    }

    // ===== CERRAR SEMANA Y GENERAR PAGOS =====
    public function cerrarSemana(Finca $finca, $semanaId)
    {
        $this->verificarPropietario($finca);

        $semana = SemanaCosecha::where('id', $semanaId)
                               ->where('finca_id', $finca->id)
                               ->firstOrFail();

        if ($semana->estado === 'cerrada') {
            return redirect()->back()->with('error', 'Esta semana ya está cerrada.');
        }

        DB::transaction(function () use ($semana, $finca): void {
            $resumen = RegistroCosecha::where('semana_id', $semana->id)
                                      ->selectRaw('trabajador_id, SUM(total_kilos) as total_kilos')
                                      ->groupBy('trabajador_id')
                                      ->get();

            foreach ($resumen as $item) {
                if ($item->total_kilos > 0) {
                    Pago::create([
                        'trabajador_id'        => $item->trabajador_id,
                        'finca_id'             => $finca->id,
                        'tipo_pago'            => 'recoleccion',
                        'fecha'                => $semana->fecha_fin,
                        'cantidad_recolectada' => $item->total_kilos,
                        'precio_por_kg'        => $semana->precio_kilo,
                        'total'                => $item->total_kilos * $semana->precio_kilo,
                    ]);
                }
            }

            $semana->update(['estado' => 'cerrada']);
        });

        return redirect()->route('cosecha.index', $finca)
                         ->with('success', 'Semana cerrada y pagos generados exitosamente.');
    }

    public function destroy(Finca $finca, $semanaId)
    {
        $this->verificarPropietario($finca);

        $semana = SemanaCosecha::where('id', $semanaId)
                               ->where('finca_id', $finca->id)
                               ->firstOrFail();

        $semana->delete();

        return redirect()->route('cosecha.index', $finca)
                         ->with('success', 'Semana eliminada exitosamente.');
    }
}