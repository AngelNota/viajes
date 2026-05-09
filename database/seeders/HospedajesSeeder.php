<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\hospedaje;
use App\Models\destino;

class HospedajesSeeder extends Seeder
{
    public function run(): void
    {
        $cancun = destino::where('nombre', 'Cancún')->first();
        $paris = destino::where('nombre', 'París')->first();
        $tokio = destino::where('nombre', 'Tokio')->first();

        hospedaje::create([
            'destino_id' => $cancun->id,
            'nombre' => 'Hard Rock Hotel Cancun',
            'categoria' => 'Resort 5 Estrellas',
            'precio_noche' => 450.00,
            'habitaciones_disp' => 20,
        ]);

        hospedaje::create([
            'destino_id' => $paris->id,
            'nombre' => 'Le Bristol Paris',
            'categoria' => 'Lujo',
            'precio_noche' => 800.00,
            'habitaciones_disp' => 10,
        ]);

        hospedaje::create([
            'destino_id' => $tokio->id,
            'nombre' => 'Park Hyatt Tokyo',
            'categoria' => 'Hotel Boutique',
            'precio_noche' => 600.00,
            'habitaciones_disp' => 15,
        ]);
    }
}
