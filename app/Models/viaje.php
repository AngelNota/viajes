<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class viaje extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'destino_id',
        'hospedaje_id',
        'transporte_id',
        'fecha_inicio',
        'fecha_fin',
        'num_personas',
        'tipo_viaje',
        'subtotal_id',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }

    public function hospedaje()
    {
        return $this->belongsTo(Hospedaje::class);
    }    
}
