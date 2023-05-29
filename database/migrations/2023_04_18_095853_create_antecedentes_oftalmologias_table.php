<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntecedentesOftalmologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedentes_oftalmologias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            $table->foreignId('conductor_id')->nullable()->references('id')->on('conductors');
            $table->foreignId('correctores_id')->nullable()->references('id')->on('correctores');
            $table->string('tipo')->nullable();
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
        Schema::dropIfExists('antecedentes_oftalmologias');
    }
}
