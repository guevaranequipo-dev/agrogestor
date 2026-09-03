<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finca extends Model
{

    protected $table = 'fincas';

    protected $fillable = [
        'user_id',
        'nombre',
        'ubicacion',
        'hectareas',
        'descripcion',
    ];

    // Una finca pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Una finca tiene muchos trabajadores
    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class);
    }

    // Una finca tiene muchas actividades
    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }

    // Una finca tiene muchas asistencias
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Una finca tiene muchos pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    // Una finca tiene muchos ingresos
    public function ingresos()
    {
        return $this->hasMany(Ingreso::class);
    }

    // Una finca tiene muchos gastos
    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }

    // Una finca tiene muchos insumos
    public function insumos()
    {
        return $this->hasMany(Insumo::class);
    }

    // Una finca tiene muchas semanas de cosecha
    public function semanasCosecha()
    {
        return $this->hasMany(SemanaCosecha::class);
    }

}