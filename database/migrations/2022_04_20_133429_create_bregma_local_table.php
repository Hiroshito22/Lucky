<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBregmaLocalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bregma_local', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('direccion')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->char('estado_registro')->default('A');
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->foreignId('departamento_id')->nullable()->references('id')->on('departamentos');
            $table->foreignId('provincia_id')->nullable()->references('id')->on('provincias');
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
        Schema::dropIfExists('bregma_local');
    }
}
