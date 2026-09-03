<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FincaController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\FinancieroController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CosechaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::resource('fincas', FincaController::class);

    Route::prefix('fincas/{finca}')->group(function () {
        Route::resource('trabajadores', TrabajadorController::class);
        Route::resource('actividades', ActividadController::class);
        Route::resource('insumos', InsumoController::class);
        Route::resource('pagos', PagoController::class);

        // Financiero
        Route::get('financiero', [FinancieroController::class, 'index'])->name('financiero.index');
        Route::get('financiero/ingresos/crear', [FinancieroController::class, 'createIngreso'])->name('financiero.createIngreso');
        Route::post('financiero/ingresos', [FinancieroController::class, 'storeIngreso'])->name('financiero.storeIngreso');
        Route::get('financiero/ingresos/{ingreso}/editar', [FinancieroController::class, 'editIngreso'])->name('financiero.editIngreso');
        Route::put('financiero/ingresos/{ingreso}', [FinancieroController::class, 'updateIngreso'])->name('financiero.updateIngreso');
        Route::delete('financiero/ingresos/{ingreso}', [FinancieroController::class, 'destroyIngreso'])->name('financiero.destroyIngreso');
        Route::get('financiero/gastos/crear', [FinancieroController::class, 'createGasto'])->name('financiero.createGasto');
        Route::post('financiero/gastos', [FinancieroController::class, 'storeGasto'])->name('financiero.storeGasto');
        Route::get('financiero/gastos/{gasto}/editar', [FinancieroController::class, 'editGasto'])->name('financiero.editGasto');
        Route::put('financiero/gastos/{gasto}', [FinancieroController::class, 'updateGasto'])->name('financiero.updateGasto');
        Route::delete('financiero/gastos/{gasto}', [FinancieroController::class, 'destroyGasto'])->name('financiero.destroyGasto');

        // Reportes
        Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');

        // Cosecha
        Route::get('cosecha', [CosechaController::class, 'index'])->name('cosecha.index');
        Route::get('cosecha/crear', [CosechaController::class, 'create'])->name('cosecha.create');
        Route::post('cosecha', [CosechaController::class, 'store'])->name('cosecha.store');
        Route::get('cosecha/{semana}', [CosechaController::class, 'show'])->name('cosecha.show');
        Route::post('cosecha/{semana}/agregar-trabajador', [CosechaController::class, 'agregarTrabajador'])->name('cosecha.agregarTrabajador');
        Route::post('cosecha/{semana}/guardar-registros', [CosechaController::class, 'guardarRegistros'])->name('cosecha.guardarRegistros');
        Route::post('cosecha/{semana}/cerrar', [CosechaController::class, 'cerrarSemana'])->name('cosecha.cerrarSemana');
        Route::delete('cosecha/{semana}', [CosechaController::class, 'destroy'])->name('cosecha.destroy');
    });
});

