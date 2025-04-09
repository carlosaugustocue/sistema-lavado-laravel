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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lavado_id')->constrained()->onDelete('cascade');
            $table->integer('tiempo_espera')->nullable()->comment('Calificación 1-5');
            $table->integer('amabilidad')->nullable()->comment('Calificación 1-5');
            $table->integer('calidad_servicio')->nullable()->comment('Calificación 1-5');
            $table->text('comentarios')->nullable();
            $table->string('token', 100)->unique()->comment('Token para acceso al formulario');
            $table->boolean('completada')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};