<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaPsicologicaOcupacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficha_psicologica_ocupacional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historia_clinica_id')->nullable()->references('id')->on('historia_clinica');
            $table->integer('numero_ficha')->nullable();
            $table->date('fecha_emision')->nullable();
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
        Schema::dropIfExists('ficha_psicologica_ocupacional');
    }
}
