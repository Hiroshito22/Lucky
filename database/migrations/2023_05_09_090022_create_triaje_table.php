<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triaje', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habito_nocivo_id')->nullable()->references('id')->on('habito_nocivo');
            //$table->foreignId('peso_talla_id')->nullable()->references('id')->on('peso_talla');
            $table->foreignId('signos_vitales_id')->nullable()->references('id')->on('signos_vitales');
            $table->foreignId('antecedente_personal_id')->nullable()->references('id')->on('antecedente_personal');
            $table->foreignId('antecedente_familiar_id')->nullable()->references('id')->on('antecedente_familiar');
            $table->foreignId('tipo_cliente_id')->nullable()->references('id')->on('tipo_cliente');
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
        Schema::dropIfExists('triaje');
    }
}
