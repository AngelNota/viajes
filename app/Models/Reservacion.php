<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservacion extends Model
{
    use SoftDeletes;

    protected $table = 'reservaciones';

    protected $fillable = [
        'user_id',
        'viaje_id',
        'folio',
        'estado',
        'monto_pagado',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'viaje_id' => 'integer',
        'monto_pagado' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viaje()
    {
        return $this->belongsTo(viaje::class);
    }
}
