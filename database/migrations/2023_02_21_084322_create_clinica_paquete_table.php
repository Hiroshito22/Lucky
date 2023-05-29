<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaPaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica_paquete', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_servicio_id')->nullable()->references('id')->on('clinica_servicio');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->string('icono')->nullable();
            $table->string('nombre')->nullable();
            // $table->unsignedBigInteger('parent_id')->nullable();
            $table->double('precio')->nullable();
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
        Schema::dropIfExists('clinica_paquete');
    }
}
