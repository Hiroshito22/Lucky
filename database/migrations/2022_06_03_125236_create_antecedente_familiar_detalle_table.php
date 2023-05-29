<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntecedenteFamiliarDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_familiar_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antecedente_familiar_id')->nullable()->references('id')->on('antecedente_familiar');
            $table->foreignId('patologia_id')->nullable()->references('id')->on('patologia');
            $table->foreignId('habito_deporte_id')->nullable()->references('id')->on('habito_deporte');
            $table->string('comentario')->nullable();
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
        Schema::dropIfExists('antecedente_familiar_detalle');
    }
}
