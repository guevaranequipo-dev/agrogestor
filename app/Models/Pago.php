<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'trabajador_id',
        'finca_id',
        'tipo_pago',
        'fecha',
        'dias_trabajados',
        'valor_dia',
        'descripcion_contrato',
        'valor_contrato',
        'cantidad_recolectada',
        'precio_por_kg',
        'total',
    ];

    // Un pago pertenece a un trabajador
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    // Un pago pertenece a una finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    // Un pago puede tener un gasto asociado en financiero
    public function gasto()
    {
        return $this->hasOne(Gasto::class);
    }

    public function sincronizarGasto(): void
    {
        $trabajador = $this->trabajador()->first();
        $nombreTrabajador = $trabajador ? $trabajador->nombre : 'trabajador';

        $this->gasto()->updateOrCreate(
            ['pago_id' => $this->id],
            [
                'finca_id' => $this->finca_id,
                'descripcion' => "Pago a {$nombreTrabajador}",
                'monto' => $this->total,
                'categoria' => 'pago',
                'fecha' => $this->fecha,
                'pago_id' => $this->id,
            ]
        );
    }

    public function eliminarGasto(): void
    {
        $this->gasto()->delete();
    }

    // Calcular el total automáticamente según el tipo de pago
    public static function calcularTotal($tipo, $data)
    {
        switch ($tipo) {
            case 'jornal':
                return $data['dias_trabajados'] * $data['valor_dia'];
            case 'contrato':
                return $data['valor_contrato'];
            case 'recoleccion':
                return $data['cantidad_recolectada'] * $data['precio_por_kg'];
            default:
                return 0;
        }
    }
}
