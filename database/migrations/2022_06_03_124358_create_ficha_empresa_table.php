<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficha_empresa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('ficha_ocupacional_id')->nullable()->references('id')->on('ficha_ocupacional');
            $table->foreignId('ficha_psicologica_ocupacional_id')->nullable()->references('id')->on('ficha_psicologica_ocupacional');
            $table->string('razon_social')->nullable();
            $table->string('actividad_economica')->nullable();
            $table->string('lugar_trabajo')->nullable();
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
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
        Schema::dropIfExists('ficha_empresa');
    }
}
