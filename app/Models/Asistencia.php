<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{

    protected $table = 'asistencias';

    protected $fillable = [
        'trabajador_id',
        'finca_id',
        'fecha',
        'presente',
        'observacion',
    ];

    // Una asistencia pertenece a un trabajador
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    // Una asistencia pertenece a una finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }
}