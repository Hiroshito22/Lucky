<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioClinicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_clinica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_id')->nullable()->references('id')->on('dias');
            //$table->foreignId('sucursal_clinica_id')->nullable()->references('id')->on('sucursal_clinica');
            $table->time('horario_inicio')->nullable();
            $table->time('horario_fin')->nullable();
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
        Schema::dropIfExists('horario_clinica');
    }
}
