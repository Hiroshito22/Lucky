<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBregmaServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bregma_servicio', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('servicio_id')->nullable()->references('id')->on('servicio');
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->string('icono')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('bregma_servicio');
    }
}
