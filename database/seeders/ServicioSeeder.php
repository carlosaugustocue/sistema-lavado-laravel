<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        Servicio::create([
            'nombre' => 'Lavado Básico',
            'descripcion' => 'Lavado exterior del vehículo con agua y jabón',
            'precio' => 15.00,
            'tiempo_estimado' => 30,
            'activo' => true,
        ]);

        Servicio::create([
            'nombre' => 'Lavado Completo',
            'descripcion' => 'Lavado exterior e interior del vehículo',
            'precio' => 25.00,
            'tiempo_estimado' => 60,
            'activo' => true,
        ]);

        Servicio::create([
            'nombre' => 'Lavado Premium',
            'descripcion' => 'Lavado completo con encerado y pulido',
            'precio' => 45.00,
            'tiempo_estimado' => 120,
            'activo' => true,
        ]);
    }
}