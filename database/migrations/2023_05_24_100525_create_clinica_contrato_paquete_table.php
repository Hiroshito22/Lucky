<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaContratoPaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica_contrato_paquete', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->nullable()->references('id')->on('contrato');
            $table->foreignId('clinica_paquete_id')->nullable()->references('id')->on('clinica_paquete');
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
        Schema::dropIfExists('clinica_contrato_paquete');
    }
}
