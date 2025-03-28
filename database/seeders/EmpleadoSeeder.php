<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        Empleado::create([
            'nombre' => 'Carlos',
            'apellido' => 'Rodríguez',
            'telefono' => '555-9876',
            'documento' => '12345678',
            'cargo' => 'Lavador',
            'activo' => true,
        ]);

        Empleado::create([
            'nombre' => 'Ana',
            'apellido' => 'Martínez',
            'telefono' => '555-4321',
            'documento' => '87654321',
            'cargo' => 'Supervisor',
            'activo' => true,
        ]);
    }
}