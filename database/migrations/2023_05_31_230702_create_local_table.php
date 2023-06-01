<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_local')->nullable();
            $table->string('direccion')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->foreignId('trabajador_id')->nullable()->references('id')->on('trabajador');
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
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
        Schema::dropIfExists('local');
    }
}
