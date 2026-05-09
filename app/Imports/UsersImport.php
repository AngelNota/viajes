<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // El documento pide columnas: nombre, correo, teléfono, fecha_nacimiento
        return new User([
            'name'             => $row['nombre'],
            'email'            => $row['correo'],
            'phone'            => $row['telefono'] ?? null,
            'fecha_nacimiento' => $row['fecha_nacimiento'] ?? null,
            'role'             => $row['rol'] ?? 'user',
            'password'         => Hash::make($row['password'] ?? '12345678'),
        ]);
    }
}
