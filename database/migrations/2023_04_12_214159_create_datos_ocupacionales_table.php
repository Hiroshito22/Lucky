<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosOcupacionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_ocupacionales', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('ficha_psicologica_ocupacional_id')->nullable()->references('id')->on('ficha_psicologica_ocupacional');
            // $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            // $table->string('nombre_empresa')->nullable();
            // $table->string('actividad_empresa')->nullable();
            // $table->string('area_trabajo')->nullable();
            // $table->string('tiempo_laborando')->nullable();
            // $table->string('puesto')->nullable();
            // $table->foreignId('principales_riesgos_id')->nullable()->references('id')->on('principales_riesgos');
            // $table->foreignId('medidas_seguridad_id')->nullable()->references('id')->on('medidas_seguridad');
            
            //$table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            $table->foreignId('motivo_evaluacion_id')->nullable()->references('id')->on('motivo_evaluacion');
            $table->foreignId('principales_riesgos_id')->nullable()->references('id')->on('principales_riesgos');
            $table->foreignId('medidas_seguridad_id')->nullable()->references('id')->on('medidas_seguridad');
            $table->foreignId('historia_familiar_id')->nullable()->references('id')->on('historia_familiar');
            $table->foreignId('accidentes_enfermedades_id')->nullable()->references('id')->on('accidentes_enfermedades');
            $table->foreignId('d_o_observaciones_id')->nullable()->references('id')->on('otras_observaciones');
            $table->foreignId('habitos_id')->nullable()->references('id')->on('habitos');
            $table->foreignId('otras_observaciones_id')->nullable()->references('id')->on('otras_observaciones');
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
        Schema::dropIfExists('datos_ocupacionales');
    }
}
