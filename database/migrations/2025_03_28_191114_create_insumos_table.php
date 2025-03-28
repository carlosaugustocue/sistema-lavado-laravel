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
    Schema::create('insumos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->decimal('costo', 10, 2);
        $table->integer('stock_actual');
        $table->integer('stock_minimo');
        $table->string('unidad_medida'); // litros, unidades, etc.
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
