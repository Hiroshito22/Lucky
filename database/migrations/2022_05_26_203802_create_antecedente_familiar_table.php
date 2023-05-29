<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntecedenteFamiliarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_familiar', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('servicio_clinica_id')->nullable()->references('id')->on('servicio_clinica');
            // $table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            // $table->foreignId('triaje')->nullable()->references('id')->on('triaje');
            // $table->foreignId('ficha_ocupacional_id')->nullable()->references('id')->on('ficha_ocupacional');
            // $table->foreignId('familiar_id')->nullable()->references('id')->on('familiar');
            // $table->string('nombres')->nullable();
            // $table->string('apellido_paterno')->nullable();
            // $table->string('apellido_materno')->nullable();
            $table->integer('numero_hijos_vivos')->nullable();
            $table->integer('numero_hijos_fallecidos')->nullable();
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
        Schema::dropIfExists('antecedente_familiar');
    }
}
