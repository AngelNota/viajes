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
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('destino_id')->constrained('destinos')->onDelete('cascade');
            $table->foreignId('hospedaje_id')->constrained('hospedajes')->onDelete('cascade');
            $table->foreignId('transporte_id')->nullable()->constrained('transportes')->onDelete('set null');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('precio_total', 10, 2);
            $table->integer('capacidad');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
