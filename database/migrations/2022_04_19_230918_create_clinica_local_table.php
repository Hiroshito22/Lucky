<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaLocalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica_local', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->foreignId('departamento_id')->nullable()->references('id')->on('departamentos');
            $table->foreignId('provincia_id')->nullable()->references('id')->on('provincias');
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
            $table->string('nombre')->nullable();
            $table->string('direccion')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->char('estado_registro')->nullable()->default('A');
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
        Schema::dropIfExists('clinica_local');
    }
}
