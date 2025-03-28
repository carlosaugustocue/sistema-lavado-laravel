<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'telefono' => '555-1234',
            'email' => 'juan@example.com',
        ]);

        Cliente::create([
            'nombre' => 'María',
            'apellido' => 'González',
            'telefono' => '555-5678',
            'email' => 'maria@example.com',
        ]);
    }
}