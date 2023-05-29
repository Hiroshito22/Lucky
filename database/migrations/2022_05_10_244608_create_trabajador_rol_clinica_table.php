<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajadorRolClinicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajador_rol_clinica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajador_clinica_id')->nullable()->references('id')->on('trabajador_clinica');
            $table->foreignId('rol_clinica_id')->nullable()->references('id')->on('rol_clinica');
            $table->foreignId('especialidad_clinica_id')->nullable()->references('id')->on('especialidad_clinica');
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
        Schema::dropIfExists('trabajador_rol_clinica');
    }
}
