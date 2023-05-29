<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgudezaVisualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agudeza_visual', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_servicio_id')->references('id')->on('clinica_servicio');
            $table->foreignId('correccion_si_id')->references('id')->on('correccion_si');
            $table->foreignId('correccion_no_id')->references('id')->on('correccion_no');
            $table->foreignId('opcion_vision_colores_id')->references('id')->on('opcion_vision_colores');
            $table->foreignId('opcion_reflejos_pupilares_id')->references('id')->on('opcion_reflejos_pupilares');
            $table->foreignId('opcion_enfermedad_ocular_id')->references('id')->on('opcion_enfermedad_ocular');
            $table->foreignId('examen_externo_id')->references('id')->on('examen_externo');
            $table->foreignId('tonometria_id')->references('id')->on('tonometria');
            $table->char('estado_registro')->default('A');
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
        Schema::dropIfExists('agudeza_visual');
    }
}
