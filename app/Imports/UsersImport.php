<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
        // Security fix: Generating random passwords instead of hardcoded '12345678'
        $password = $row['password'] ?? Str::random(12);

        return new User([
            'name'     => $row['nombre'],
            'email'    => $row['email'],
            'role'     => $row['rol'] ?? 'user',
            'password' => Hash::make($password),
        ]);
    }
}
