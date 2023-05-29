<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamenMentalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_mental', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            $table->foreignId('presentacion_id')->nullable()->references('id')->on('presentacion');
            $table->foreignId('postura_id')->nullable()->references('id')->on('postura');
            $table->foreignId('ritmo_id')->nullable()->references('id')->on('ritmo');
            $table->foreignId('tono_id')->nullable()->references('id')->on('tono');
            $table->foreignId('articulacion_id')->nullable()->references('id')->on('articulacion');
            $table->foreignId('tiempo_id')->nullable()->references('id')->on('tiempo');
            $table->foreignId('espacio_id')->nullable()->references('id')->on('espacio');
            $table->foreignId('persona_mental_id')->nullable()->references('id')->on('persona_mental');
            $table->foreignId('coordinacion_visomotriz_id')->nullable()->references('id')->on('coordinacion_visomotriz');
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
        Schema::dropIfExists('examen_mental');
    }
}
