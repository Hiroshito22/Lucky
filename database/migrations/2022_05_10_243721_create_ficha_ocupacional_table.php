<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaOcupacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficha_ocupacional', function (Blueprint $table) {
            $table->id();
            $table->foreignId("historia_clinica_id")->nullable()->references('id')->on('historia_clinica');
            $table->foreignId("tipo_evaluacion_id")->nullable()->references('id')->on('tipo_evaluacion');
            $table->foreignId("atencion_id")->nullable()->references('id')->on('atencion');
            $table->string('lugar_examen_departamento')->nullable();
            $table->string('lugar_examen_provincia')->nullable();
            $table->string('lugar_examen_distrito')->nullable();
            $table->date('fecha_emision')->nullable();
            $table->string('puesto_evaluacion')->nullable();
            $table->string('inmunizaciones')->nullable();
            $table->string('estado_atencion')->nullable();
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
        Schema::dropIfExists('ficha_ocupacional');
    }
}
