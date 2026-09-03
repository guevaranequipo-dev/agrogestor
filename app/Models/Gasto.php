<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{

    protected $table = 'gastos';

    protected $fillable = [
        'finca_id',
        'pago_id',
        'descripcion',
        'monto',
        'categoria',
        'fecha',
    ];

    // Un gasto pertenece a una finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    // Un gasto puede venir de un pago
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}
