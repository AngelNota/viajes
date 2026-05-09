<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\viaje;
use App\Models\destino;
use App\Models\hospedaje;
use App\Models\transporte;

class ViajesSeeder extends Seeder
{
    public function run(): void
    {
        $cancun = destino::where('nombre', 'Cancún')->first();
        $hotelCancun = hospedaje::where('destino_id', $cancun->id)->first();
        $vueloCancun = transporte::where('destino', 'Cancún')->first();

        viaje::create([
            'nombre' => 'Paraíso Caribeño',
            'destino_id' => $cancun->id,
            'hospedaje_id' => $hotelCancun->id,
            'transporte_id' => $vueloCancun->id,
            'fecha_inicio' => now()->addDays(10)->toDateString(),
            'fecha_fin' => now()->addDays(17)->toDateString(),
            'precio_total' => 2500.00,
            'capacidad' => 10,
        ]);

        $paris = destino::where('nombre', 'París')->first();
        $hotelParis = hospedaje::where('destino_id', $paris->id)->first();
        $vueloParis = transporte::where('destino', 'París')->first();

        viaje::create([
            'nombre' => 'Luces de Europa',
            'destino_id' => $paris->id,
            'hospedaje_id' => $hotelParis->id,
            'transporte_id' => $vueloParis->id,
            'fecha_inicio' => now()->addDays(15)->toDateString(),
            'fecha_fin' => now()->addDays(20)->toDateString(),
            'precio_total' => 4200.00,
            'capacidad' => 5,
        ]);
    }
}
