<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemanaCosecha extends Model
{
    protected $table = 'semanas_cosecha';

    protected $fillable = [
        'finca_id',
        'fecha_inicio',
        'fecha_fin',
        'precio_kilo',
        'estado',
    ];

    // Una semana pertenece a una finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    // Una semana tiene muchos registros
    public function registros()
    {
        return $this->hasMany(RegistroCosecha::class, 'semana_id');
    }

    // Trabajadores únicos en esta semana
    public function trabajadores()
    {
        return $this->belongsToMany(Trabajador::class, 'registros_cosecha', 'semana_id', 'trabajador_id')
                    ->distinct();
    }

    // Total kilos de toda la semana
    public function totalKilos()
    {
        return $this->registros()->sum('total_kilos');
    }

    // Total a pagar de toda la semana
    public function totalPagar()
    {
        return $this->totalKilos() * $this->precio_kilo;
    }
}