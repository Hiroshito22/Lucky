<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitosNocivosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitos_nocivos_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habito_id')->nullable()->references('id')->on('habito');
            $table->foreignId('habito_nocivo_id')->nullable()->references('id')->on('habito_nocivo');
            $table->foreignId('frecuencia_id')->nullable()->references('id')->on('frecuencia');
            $table->time('tiempo')->nullable();
            $table->string('tipo')->nullable();
            $table->string('unidad')->nullable();
            $table->double('cantidad')->nullable();
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
        Schema::dropIfExists('habitos_nocivos_detalles');
    }
}
