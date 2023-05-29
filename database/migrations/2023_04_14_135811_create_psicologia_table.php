<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsicologiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psicologia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('datos_ocupacionales_id')->nullable()->references('id')->on('datos_ocupacionales');
            $table->foreignId('examen_mental_id')->nullable()->references('id')->on('datos_ocupacionales');
            $table->foreignId('proceso_cognoscitivo_id')->nullable()->references('id')->on('proceso_cognoscitivo');
            $table->foreignId('preguntas_id')->nullable()->references('id')->on('preguntas');
            $table->foreignId('diagnostico_final_id')->nullable()->references('id')->on('diagnostico_final');
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
        Schema::dropIfExists('psicologia');
    }
}
