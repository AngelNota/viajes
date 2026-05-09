<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Administrador por defecto
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('12345678'),
        ]);

        // Cliente por defecto
        User::factory()->create([
            'name' => 'Gerardo Varela',
            'email' => 'gerardo@example.com',
            'role' => 'user',
            'password' => bcrypt('12345678'),
        ]);

        $this->call([
            DestinosSeeder::class,
            HospedajesSeeder::class,
            TransportesSeeder::class,
            ViajesSeeder::class,
        ]);
    }
}
