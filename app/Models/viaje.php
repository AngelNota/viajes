<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class viaje extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'destino_id',
        'hospedaje_id',
        'transporte_id',
        'fecha_inicio',
        'fecha_fin',
        'precio_total',
        'capacidad',
    ];

    public function destino()
    {
        return $this->belongsTo(destino::class);
    }

    public function hospedaje()
    {
        return $this->belongsTo(hospedaje::class);
    }

    public function transporte()
    {
        return $this->belongsTo(transporte::class);
    }

    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class);
    }
}
