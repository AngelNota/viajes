<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hospedaje extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'destino_id',
        'nombre',
        'categoria',
        'precio_noche',
        'habitaciones_disp',
        'imagen',
    ];

    public function destino()
    {
        return $this->belongsTo(destino::class);
    }

    public function viajes()
    {
        return $this->hasMany(viaje::class);
    }
}
