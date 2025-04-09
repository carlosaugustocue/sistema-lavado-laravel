<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_un_cliente()
    {
        $cliente = Cliente::create([
            'nombre' => 'Carlos Augusto',
            'apellido' => 'Aranzazu',
            'telefono' => '3101234567',
            'email' => 'carlos@example.com',
        ]);

        $this->assertDatabaseHas('clientes', [
            'nombre' => 'Carlos Augusto',
        ]);
    }

    /** @test */
    public function no_puede_crear_cliente_sin_telefono()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Cliente::create([
            'nombre' => 'Cliente sin teléfono',
            // falta el campo 'telefono'
        ]);
    }
}
