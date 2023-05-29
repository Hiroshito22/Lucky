<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            $table->foreignId('vision_colores_id')->nullable()->references('id')->on('vision_colores');
            $table->integer('reconoce_colores')->nullable();
            $table->integer('dificultad_color')->nullable();
            $table->foreignId('estereopsis_id')->nullable()->references('id')->on('estereopsis');
            $table->foreignId('examen_segmentado_id')->nullable()->references('id')->on('examen_segmentado');
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
        Schema::dropIfExists('test');
    }
}
