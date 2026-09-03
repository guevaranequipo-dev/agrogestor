<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{

    protected $table = 'trabajadores';

    protected $fillable = [
        'finca_id',
        'nombre',
        'cedula',
        'telefono',
        'salario_dia',
        'estado',
    ];

    // Un trabajador pertenece a una finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    // Un trabajador tiene muchas asistencias
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Un trabajador tiene muchos pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    // Un trabajador pertenece a muchas actividades
    public function actividades()
    {
        return $this->belongsToMany(Actividad::class)
                    ->withPivot('rol', 'observacion')
                    ->withTimestamps();
    }

    // Un trabajador tiene muchos registros de cosecha
    public function registrosCosecha()
    {
        return $this->hasMany(RegistroCosecha::class);
    }

}
