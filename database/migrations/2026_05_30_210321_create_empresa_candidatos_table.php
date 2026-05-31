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
    Schema::create('empresa_candidatos', function (Blueprint $table) {
        $table->id();

        $table->foreignId('empresa_id')
            ->constrained('empresas')
            ->onDelete('cascade');

        $table->foreignId('candidato_id')
            ->constrained('candidatos')
            ->onDelete('cascade');

        $table->string('cargo_buscado');
        $table->string('estado_proceso')->default('pendiente');
        $table->text('observacion')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_candidatos');
    }
};
