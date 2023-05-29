<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisionLejosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vision_lejos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ojo_derecho_id')->references('id')->on('medida_lejos');
            $table->foreignId('ojo_izquierdo_id')->references('id')->on('medida_lejos');
            $table->foreignId('binocular_id')->references('id')->on('medida_lejos');
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
        Schema::dropIfExists('vision_lejos');
    }
}
