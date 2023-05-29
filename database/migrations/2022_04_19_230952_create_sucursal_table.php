<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursal', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->nullable();
            $table->string("direccion")->nullable();
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            //$table->foreignId('hospital_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
            $table->foreignId('provincia_id')->nullable()->references('id')->on('provincias');
            $table->foreignId('departamento_id')->nullable()->references('id')->on('departamentos');
            $table->string("latitud")->nullable();
            $table->string("longitud")->nullable();
            $table->char("estado_registro")->default("A");
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
        Schema::dropIfExists('sucursal');
    }
}
