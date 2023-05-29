<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBregmaPaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bregma_paquete', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->foreignId('bregma_servicio_id')->nullable()->references('id')->on('bregma_servicio');
            $table->string('icono')->nullable();
            $table->string('nombre')->nullable();
            $table->double('precio_mensual')->nullable();
            $table->double('precio_anual')->nullable();
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
        Schema::dropIfExists('bregma_paquete');
    }
}
