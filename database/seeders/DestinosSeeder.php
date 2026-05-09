<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\destino;

class DestinosSeeder extends Seeder
{
    public function run(): void
    {
        destino::create([
            'nombre' => 'Cancún',
            'pais' => 'México',
            'descripcion' => 'Playas de arena blanca y aguas cristalinas en el Caribe mexicano.',
            'precio_base' => 1500.00,
            'activo' => true,
        ]);

        destino::create([
            'nombre' => 'París',
            'pais' => 'Francia',
            'descripcion' => 'La ciudad del amor, famosa por su arquitectura, arte y gastronomía.',
            'precio_base' => 3500.00,
            'activo' => true,
        ]);

        destino::create([
            'nombre' => 'Tokio',
            'pais' => 'Japón',
            'descripcion' => 'Una mezcla fascinante de tradición milenaria y tecnología futurista.',
            'precio_base' => 4500.00,
            'activo' => true,
        ]);
    }
}
