<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\transporte;

class TransportesSeeder extends Seeder
{
    public function run(): void
    {
        transporte::create([
            'tipo' => 'avión',
            'origen' => 'Ciudad de México',
            'destino' => 'Cancún',
            'capacidad' => 150,
            'precio' => 200.00,
            'fecha_salida' => now()->addDays(10)->setHour(10)->setMinute(0),
        ]);

        transporte::create([
            'tipo' => 'avión',
            'origen' => 'Madrid',
            'destino' => 'París',
            'capacidad' => 120,
            'precio' => 150.00,
            'fecha_salida' => now()->addDays(15)->setHour(14)->setMinute(30),
        ]);

        transporte::create([
            'tipo' => 'tren',
            'origen' => 'Kioto',
            'destino' => 'Tokio',
            'capacidad' => 80,
            'precio' => 100.00,
            'fecha_salida' => now()->addDays(20)->setHour(9)->setMinute(0),
        ]);
    }
}
