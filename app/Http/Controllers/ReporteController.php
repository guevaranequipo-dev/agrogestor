<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use App\Models\Trabajador;
use App\Models\Actividad;
use App\Models\Pago;
use App\Models\Ingreso;
use App\Models\Gasto;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReporteController extends FincaBaseController
{
    public function index(Finca $finca)
    {
        $this->verificarPropietario($finca);

        // Trabajadores
        $totalTrabajadores = Trabajador::where('finca_id', $finca->id)->count();
        $trabajadoresActivos = Trabajador::where('finca_id', $finca->id)->where('estado', true)->count();

        // Actividades
        $actividadesPendientes = Actividad::where('finca_id', $finca->id)->where('estado', 'pendiente')->count();
        $actividadesEnProgreso = Actividad::where('finca_id', $finca->id)->where('estado', 'en_progreso')->count();
        $actividadesCompletadas = Actividad::where('finca_id', $finca->id)->where('estado', 'completada')->count();

        // Insumos
        $totalInsumos = Insumo::where('finca_id', $finca->id)->count();

        // Pagos por tipo
        $pagosPorTipo = Pago::where('finca_id', $finca->id)
                            ->selectRaw('tipo_pago, SUM(total) as total, COUNT(*) as cantidad')
                            ->groupBy('tipo_pago')
                            ->get();

        $totalPagado = Pago::where('finca_id', $finca->id)->sum('total');

        // Top trabajadores por pagos
        $topTrabajadores = Pago::where('finca_id', $finca->id)
                               ->with('trabajador')
                               ->selectRaw('trabajador_id, SUM(total) as total_pagado, COUNT(*) as cantidad_pagos')
                               ->groupBy('trabajador_id')
                               ->orderByDesc('total_pagado')
                               ->take(5)
                               ->get();

        // Ingresos y gastos por mes (últimos 6 meses)
    $meses = [];
    $ingresosPorMes = [];
    $gastosPorMes = [];

    for ($i = 5; $i >= 0; $i--) {
        $mes = Carbon::now()->startOfMonth()->subMonths($i);
        $meses[] = $mes->translatedFormat('M Y');

        $ingresosPorMes[] = Ingreso::where('finca_id', $finca->id)
            ->whereYear('fecha', $mes->year)
            ->whereMonth('fecha', $mes->month)
            ->sum('monto');

        $gastosPorMes[] = Gasto::where('finca_id', $finca->id)
            ->whereYear('fecha', $mes->year)
            ->whereMonth('fecha', $mes->month)
            ->sum('monto');
    }

        // Balance general
        $totalIngresos = Ingreso::where('finca_id', $finca->id)->sum('monto');
        $totalGastos = Gasto::where('finca_id', $finca->id)->sum('monto');
        $balance = $totalIngresos - $totalGastos;

        return view('reportes.index', compact(
            'finca',
            'totalTrabajadores',
            'trabajadoresActivos',
            'actividadesPendientes',
            'actividadesEnProgreso',
            'actividadesCompletadas',
            'totalInsumos',
            'pagosPorTipo',
            'totalPagado',
            'topTrabajadores',
            'meses',
            'ingresosPorMes',
            'gastosPorMes',
            'totalIngresos',
            'totalGastos',
            'balance'
        ));
    }
}
