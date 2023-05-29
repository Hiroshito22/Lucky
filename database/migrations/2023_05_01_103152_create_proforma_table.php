<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->nullable()->references('id')->on('lead');
            $table->foreignId('tipo_cliente_id')->nullable()->references('id')->on('tipo_cliente');
            //$table->foreignId('clinica_empresa_id')->nullable()->references('id')->on('clinica_empresa');
            $table->foreignId('bregma_paquete_id')->nullable()->references('id')->on('bregma_paquete');
            $table->string('codigo')->nullable();
            $table->string('estado')->nullable();
            $table->string('tipo_negociacion')->nullable();
            $table->string('comentario')->nullable();
            $table->string('documento_proforma')->nullable();
            $table->string('documento_evidencia')->nullable();
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
        Schema::dropIfExists('proforma');
    }
}
