<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroCosecha extends Model
{
    protected $table = 'registros_cosecha';

    protected $fillable = [
        'semana_id',
        'trabajador_id',
        'fecha',
        'kilos_manana',
        'kilos_tarde',
        'total_kilos',
    ];

    // Un registro pertenece a una semana
    public function semana()
    {
        return $this->belongsTo(SemanaCosecha::class, 'semana_id');
    }

    // Un registro pertenece a un trabajador
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    // Calcular total automáticamente
    public static function calcularTotal($kilosManana, $kilosTarde)
    {
        return floatval($kilosManana) + floatval($kilosTarde);
    }
}