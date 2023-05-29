<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntecedentesSistemicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedentes_sistemicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antecedentes_oftalmologias_id')->nullable()->references('id')->on('antecedentes_oftalmologias');
            $table->foreignId('enfermedades_sistemicos_id')->nullable()->references('id')->on('enfermedades_sistemicos');
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
        Schema::dropIfExists('antecedentes_sistemicos');
    }
}
