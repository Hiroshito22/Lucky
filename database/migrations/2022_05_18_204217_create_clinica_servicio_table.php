<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->nullable()->references('id')->on('servicio');
            // $table->foreignId('clinica_paquete_id')->nullable()->references('id')->on('clinica_paquete');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->foreignId('ficha_medico_ocupacional_id')->nullable()->references('id')->on('ficha_medico_ocupacional');
            $table->string('nombre')->nullable();
            $table->string('icono')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('clinica_servicio');
    }
}
