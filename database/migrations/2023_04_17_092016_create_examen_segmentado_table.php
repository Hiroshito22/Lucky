<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamenSegmentadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_segmentado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ojo_derecho_id')->nullable()->references('id')->on('segmento');
            $table->foreignId('ojo_izquierdo_id')->nullable()->references('id')->on('segmento');
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
        Schema::dropIfExists('examen_segmentado');
    }
}
