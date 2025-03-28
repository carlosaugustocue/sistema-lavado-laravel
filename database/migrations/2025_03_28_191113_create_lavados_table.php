<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('lavados', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehiculo_id')->constrained();
        $table->foreignId('empleado_id')->constrained(); // empleado que recibe
        $table->foreignId('empleado_asignado_id')->nullable(); // empleado que realiza el lavado
        $table->foreignId('servicio_id')->constrained();
        $table->dateTime('hora_entrada');
        $table->dateTime('hora_salida')->nullable();
        $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'entregado'])->default('pendiente');
        $table->decimal('costo_total', 10, 2);
        $table->text('observaciones')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lavados');
    }
};
