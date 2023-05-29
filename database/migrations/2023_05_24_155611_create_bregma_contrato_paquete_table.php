<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBregmaContratoPaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bregma_contrato_paquete', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->nullable()->references('id')->on('contrato');
            $table->foreignId('bregma_paquete_id')->nullable()->references('id')->on('bregma_paquete');
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
        Schema::dropIfExists('bregma_contrato_paquete');
    }
}
