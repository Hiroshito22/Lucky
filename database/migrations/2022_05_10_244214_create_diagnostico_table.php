<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostico', function (Blueprint $table) {
            $table->id();
            $table->foreignId("ficha_ocupacional_id")->nullable()->references('id')->on('ficha_ocupacional');
            $table->foreignId("servicio_id")->nullable()->references('id')->on('servicio');
            $table->foreignId("atencion_id")->nullable()->references('id')->on('atencion');
            $table->foreignId("enfermedad_id")->nullable()->references('id')->on('enfermedad');
            $table->foreignId("enfermedad_general_id")->nullable()->references('id')->on('enfermedad_general');
            $table->foreignId("enfermedad_especifica_id")->nullable()->references('id')->on('enfermedad_especifica');
            $table->foreignId("subarea_id")->nullable()->references('id')->on('subarea');
            $table->foreignId("area_id")->nullable()->references('id')->on('area');
            $table->foreignId("clinica_area_id")->nullable()->references('id')->on('clinica_area');
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
        Schema::dropIfExists('diagnostico');
    }
}
