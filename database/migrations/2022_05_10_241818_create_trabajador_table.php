<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajador', function (Blueprint $table) {
            $table->id();
            $table->char('estado_trabajador')->nullable();
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('sucursal_id')->nullable()->references('id')->on('sucursal');
            $table->foreignId('subarea_id')->nullable()->references('id')->on('subarea');
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
            $table->foreignId('user_rol_id')->nullable()->references('id')->on('users_rol');
            $table->foreignId('cargo_id')->nullable()->references('id')->on('cargo');
            $table->string('puesto')->nullable();
            $table->foreignId('tipo_trabajador_id')->nullable()->references('id')->on('tipo_trabajador');
            $table->char('estado_registro')->default('A')->nullable();
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
        Schema::dropIfExists('trabajador');
    }
}
