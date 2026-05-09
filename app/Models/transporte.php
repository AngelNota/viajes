<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class transporte extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tipo',
        'origen',
        'destino',
        'capacidad',
        'precio',
        'fecha_salida',
    ];

    public function viajes()
    {
        return $this->hasMany(viaje::class);
    }
}
