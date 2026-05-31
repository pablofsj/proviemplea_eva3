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
    Schema::create('candidatos', function (Blueprint $table) {
        $table->id();

        // Datos privados / CV ciego
        $table->string('nombre');
        $table->string('email')->unique();
        $table->string('telefono')->nullable();
        $table->integer('edad')->nullable();
        $table->string('genero')->nullable();
        $table->string('comuna_residencia')->nullable();

        // Datos visibles para empresas
        $table->string('nivel_educacional');
        $table->text('experiencia_laboral');
        $table->text('habilidades');
        $table->text('certificaciones')->nullable();
        $table->text('referencias')->nullable();

        $table->boolean('estado')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
