<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajadorClinicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajador_clinica', function (Blueprint $table) {
            $table->id();
            $table->char('estado_registro')->default('A');
            //$table->foreignId('sucursal_clinica_id')->nullable()->references('id')->on('sucursal_clinica');
            $table->foreignId('user_rol_id')->nullable()->references('id')->on('users_rol');
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
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
        Schema::dropIfExists('trabajador_clinica');
    }
}
