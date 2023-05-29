<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitoNocivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habito_nocivo', function (Blueprint $table) {
            $table->id();
            // $table->foreignId("servicio_clinica")->nullable()->references('id')->on('servicio_clinica');
            //$table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            //$table->foreignId("habito_deporte_id")->nullable()->references('id')->on('habito_deporte');
            $table->string('medicamento')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('deporte')->nullable();
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
        Schema::dropIfExists('habito_nocivo');
    }
}
