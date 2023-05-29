<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_personal_id')->nullable()->references('id')->on('empresa_personal');
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
            $table->foreignId('hoja_ruta_id')->nullable()->references('id')->on('hoja_ruta');
            $table->date('fecha')->nullable();
            $table->foreignId('clinica_local_id')->nullable()->references('id')->on('clinica_local');
            $table->char('estado_atencion')->default('0'); // 0-en espera  1-en atencion  2-atendido 3-no atendido
            $table->char('estado_registro')->default('A');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paciente');
    }
}
