<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotivoEvaluacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motivo_evaluacion', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('ficha_psicologica_ocupacional_id')->nullable()->references('id')->on('ficha_psicologica_ocupacional');
            //$table->string('motivo_evaluacion')->nullable();
            $table->string('nombre')->nullable();
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
        Schema::dropIfExists('motivo_evaluacion');
    }
}
