<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_cliente_id')->nullable()->references('id')->on('tipo_cliente');
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('bregma_paquete_id')->nullable()->references('id')->on('bregma_paquete');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->integer('estado_contrato')->nullable();
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
        Schema::dropIfExists('contrato');
    }
}
