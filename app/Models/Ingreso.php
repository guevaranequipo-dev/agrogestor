<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{

    protected $table = 'ingresos';

    protected $fillable = [
        'finca_id',
        'descripcion',
        'monto',
        'categoria',
        'fecha',
    ];

    // Un ingreso pertenece a una finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }
}
