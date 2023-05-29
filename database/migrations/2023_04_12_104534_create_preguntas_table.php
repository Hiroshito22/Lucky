<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            $table->foreignId('evaluacion_psicopatologica_id')->nullable()->references('id')->on('evaluacion_psicopatologicas');
            $table->foreignId('evaluacion_organica_id')->nullable()->references('id')->on('evaluacion_organicas');
            $table->foreignId('evaluacion_emocional_id')->nullable()->references('id')->on('evaluacion_emocionals');
            $table->foreignId('sano_mentalmente_id')->nullable()->references('id')->on('sano_mentalmentes');
            $table->foreignId('tipo_estres_id')->nullable()->references('id')->on('tipo_estres');
            $table->foreignId('test_somnolenda_id')->nullable()->references('id')->on('test_somnolendas');
            $table->foreignId('test_fatiga_id')->nullable()->references('id')->on('test_fatigas');
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
        Schema::dropIfExists('preguntas');
    }
}
