<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoAFamiliar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fo_a_familiar', function (Blueprint $table) {
            $table->id();
            $table->string('observaciones_finales')->nullable();
            //$table->foreignId('seccion_activado_id')->nullable()->references('id')->on('seccion_activado');
            $table->foreignId('ficha_ocupacional_id')->nullable()->references('id')->on('ficha_ocupacional');
            $table->foreignId('familiar_id')->nullable()->references('id')->on('familiar');
            $table->foreignId('hospital_familiar_id')->nullable()->references('id')->on('hospital');
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
        Schema::dropIfExists('fo_a_familiar');
    }
}
