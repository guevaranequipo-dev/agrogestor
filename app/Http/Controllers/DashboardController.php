<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use App\Models\Trabajador;
use App\Models\Pago;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $fincas = Finca::where('user_id', Auth::id())
            ->withCount(['trabajadores', 'actividades'])
            ->withSum('pagos', 'total')
            ->latest()
            ->get();

        $fincaIds = $fincas->pluck('id');

        return view('dashboard', [
            'fincas' => $fincas,
            'totalFincas' => $fincas->count(),
            'totalTrabajadores' => Trabajador::whereIn('finca_id', $fincaIds)->count(),
            'totalPagos' => Pago::whereIn('finca_id', $fincaIds)->sum('total'),
            'totalActividades' => Actividad::whereIn('finca_id', $fincaIds)->count(),
        ]);
    }
}
