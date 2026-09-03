<?php

use App\Models\Finca;
use App\Models\Pago;
use App\Models\Trabajador;
use App\Models\User;

it('creates a gasto when a pago is created', function () {
    $user = User::factory()->create();

    $finca = Finca::create([
        'user_id' => $user->id,
        'nombre' => 'Finca Test',
        'ubicacion' => 'Ubicación Test',
        'hectareas' => 10,
        'descripcion' => 'Finca para pruebas',
    ]);

    $trabajador = Trabajador::create([
        'finca_id' => $finca->id,
        'nombre' => 'Juan Pérez',
        'cedula' => '1234567890',
        'telefono' => '3001234567',
        'salario_dia' => 100,
        'estado' => true,
    ]);

    $response = $this->actingAs($user)->post("/fincas/{$finca->id}/pagos", [
        'trabajador_id' => $trabajador->id,
        'tipo_pago' => 'jornal',
        'fecha' => '2026-08-03',
        'dias_trabajados' => 5,
        'valor_dia' => 100,
    ]);

    $response->assertRedirect(route('pagos.index', $finca));

    $pago = Pago::where('finca_id', $finca->id)->latest()->first();

    $this->assertNotNull($pago);
    $this->assertDatabaseHas('gastos', [
        'finca_id' => $finca->id,
        'pago_id' => $pago->id,
        'monto' => 500,
        'categoria' => 'pago',
        'descripcion' => 'Pago a Juan Pérez',
    ]);
});
