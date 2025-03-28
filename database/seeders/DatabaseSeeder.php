<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ClienteSeeder::class,
            EmpleadoSeeder::class,
            ServicioSeeder::class,
            InsumoSeeder::class,
        ]);
    }
}