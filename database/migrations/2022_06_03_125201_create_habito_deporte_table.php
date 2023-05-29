<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitoDeporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habito_deporte', function (Blueprint $table) {
            $table->id();
            $table->foreignId("habito_nocivo_id")->nullable()->references('id')->on('habito_nocivo');
            $table->foreignId("frecuencia_id")->nullable()->references('id')->on('frecuencia');
            $table->foreignId("deporte_id")->nullable()->references('id')->on('deporte');
            $table->foreignId("tiempo_id")->nullable()->references('id')->on('tiempo');
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
        Schema::dropIfExists('habito_deporte');
    }
}
