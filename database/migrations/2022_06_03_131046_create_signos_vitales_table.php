<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignosVitalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signos_vitales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_ocupacional_id')->nullable()->references('id')->on('ficha_ocupacional');
            // $table->foreignId('servicio_clinica_id')->nullable()->references('id')->on('servicio_clinica');
            $table->double('frec_cardiaca')->nullable();
            $table->double('frec_respiratoria')->nullable();
            $table->double('p_sistolica')->nullable();
            $table->double('p_diastolica')->nullable();
            $table->double('p_media')->nullable();
            $table->double('saturacion',8,2)->nullable();
            $table->double('temperatura',8,2)->nullable();
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('signos_vitales');
    }
}
