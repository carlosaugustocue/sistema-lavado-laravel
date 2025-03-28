<?php

namespace Database\Seeders;

use App\Models\Insumo;
use Illuminate\Database\Seeder;

class InsumoSeeder extends Seeder
{
    public function run(): void
    {
        Insumo::create([
            'nombre' => 'Jabón para autos',
            'descripcion' => 'Jabón especial para limpieza de carrocería',
            'costo' => 10.00,
            'stock_actual' => 50,
            'stock_minimo' => 10,
            'unidad_medida' => 'litros',
        ]);

        Insumo::create([
            'nombre' => 'Cera para autos',
            'descripcion' => 'Cera de alta calidad para brillo',
            'costo' => 25.00,
            'stock_actual' => 30,
            'stock_minimo' => 5,
            'unidad_medida' => 'unidades',
        ]);

        Insumo::create([
            'nombre' => 'Limpiador de interiores',
            'descripcion' => 'Limpiador para tapicería y plásticos',
            'costo' => 15.00,
            'stock_actual' => 40,
            'stock_minimo' => 8,
            'unidad_medida' => 'litros',
        ]);
    }
}