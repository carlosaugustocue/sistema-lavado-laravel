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
    Schema::create('uso_insumos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lavado_id')->constrained();
        $table->foreignId('insumo_id')->constrained();
        $table->decimal('cantidad', 8, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uso_insumos');
    }
};
