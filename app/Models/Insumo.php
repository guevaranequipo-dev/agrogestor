<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
        'finca_id',
        'nombre',
        'tipo',
        'unidad_medida',
        'cantidad_disponible',
        'precio_unitario',
        'descripcion',
    ];

    // Un insumo pertenece a una finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }
}
