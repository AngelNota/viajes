<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hospedaje extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'direccion',
        'capacidad',
        'tipo',
        'imagen',
    ];
}
