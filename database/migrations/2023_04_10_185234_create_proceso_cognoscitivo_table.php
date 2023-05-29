<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoCognoscitivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_cognoscitivo', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('ficha_psicologica_ocupacional_id')->nullable()->references('id')->on('ficha_psicologica_ocupacional');
            // $table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            $table->foreignId('lucido_atento_id')->nullable()->references('id')->on('lucido_atento');
            $table->foreignId('pensamiento_id')->nullable()->references('id')->on('pensamiento');
            $table->foreignId('percepcion_id')->nullable()->references('id')->on('percepcion');
            $table->foreignId('memoria_id')->nullable()->references('id')->on('memoria');
            $table->foreignId('inteligencia_id')->nullable()->references('id')->on('inteligencia');
            $table->foreignId('apetito_id')->nullable()->references('id')->on('apetito');
            $table->foreignId('suenno_id')->nullable()->references('id')->on('suenno');
            $table->foreignId('personalidad_id')->nullable()->references('id')->on('personalidad');
            $table->foreignId('afectividad_id')->nullable()->references('id')->on('afectividad');
            $table->foreignId('conducta_sexual_id')->nullable()->references('id')->on('conducta_sexual');
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
        Schema::dropIfExists('proceso_cognoscitivo');
    }
}
