<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamenExternoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_externo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opcion_ojo_derecho_id')->references('id')->on('opcion_ojo_derecho');
            $table->foreignId('opcion_ojo_izquierdo_id')->references('id')->on('opcion_ojo_izquierdo');
            $table->string('examen_clinico')->nullable();
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
        Schema::dropIfExists('examen_externo');
    }
}
