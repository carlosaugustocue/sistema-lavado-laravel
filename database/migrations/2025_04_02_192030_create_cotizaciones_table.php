<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->foreignId('producto_cotizable_id')->constrained('productos_cotizables')->onDelete('cascade');
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad_minima')->default(1);
            $table->text('observaciones')->nullable();
            $table->boolean('disponibilidad_inmediata')->default(true);
            $table->timestamps();
            
            // Un proveedor solo puede cotizar un precio por producto
            $table->unique(['proveedor_id', 'producto_cotizable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};