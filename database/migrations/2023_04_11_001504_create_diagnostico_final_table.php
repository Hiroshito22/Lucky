<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticoFinalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostico_final', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            $table->foreignId('area_cognitiva_id')->nullable()->references('id')->on('area_cognitiva');
            $table->foreignId('area_emocional_id')->nullable()->references('id')->on('area_emocional');
            $table->foreignId('recomendaciones_id')->nullable()->references('id')->on('recomendaciones');
            $table->foreignId('resultado_id')->nullable()->references('id')->on('resultado');;
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
        Schema::dropIfExists('diagnostico_final');
    }
}
