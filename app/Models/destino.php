<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class destino extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'ciudad',
        'pais',
        'direccion',
        'imagen',
    ];

    protected $casts = [
        'imagen' => 'array',
    ];
}
