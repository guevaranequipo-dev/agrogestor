<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{

    protected $table = 'actividades';

    protected $fillable = [
        'finca_id',
        'nombre',
        'descripcion',
        'fecha_programada',
        'estado',
    ];

    // Una actividad pertenece a una finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    // Una actividad pertenece a muchos trabajadores
    public function trabajadores()
    {
        return $this->belongsToMany(Trabajador::class)
                    ->withPivot('rol', 'observacion')
                    ->withTimestamps();
    }
}