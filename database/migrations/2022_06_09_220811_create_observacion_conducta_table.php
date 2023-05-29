<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionConductaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observacion_conducta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_psicologica_ocupacional_id')->nullable()->references('id')->on('ficha_psicologica_ocupacional');
            $table->string('presentacion_id')->nullable();
            $table->string('postura_id')->nullable();
            $table->foreignId('ritmo_id')->nullable()->references('id')->on('ritmo');
            $table->foreignId('tono_id')->nullable()->references('id')->on('tono');
            $table->foreignId('articulacion_id')->nullable()->references('id')->on('articulacion');
            $table->foreignId('tiempo_id')->nullable()->references('id')->on('tiempo');
            $table->foreignId('espacio_id')->nullable()->references('id')->on('espacio');
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
        Schema::dropIfExists('observacion_conducta');
    }
}
