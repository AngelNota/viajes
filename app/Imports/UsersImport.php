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
        // Se espera un Excel con las cabeceras: nombre, email, rol, password
        // Si no hay password, se asigna uno por defecto '12345678'
        return new User([
            'name'     => $row['nombre'],
            'email'    => $row['email'],
            'role'     => $row['rol'] ?? 'user',
            'password' => Hash::make($row['password'] ?? '12345678'),
        ]);
    }
}
