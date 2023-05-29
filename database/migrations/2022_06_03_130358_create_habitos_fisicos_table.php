<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitosFisicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitos_fisicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_ocupacional_id')->nullable()->references('id')->on('ficha_ocupacional');
            $table->foreignId('frecuencia_id')->nullable()->references('id')->on('frecuencia');
            $table->foreignId('deporte_id')->nullable()->references('id')->on('deporte');
            $table->time('tiempo')->nullable();
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('habitos_fisicos');
    }
}
