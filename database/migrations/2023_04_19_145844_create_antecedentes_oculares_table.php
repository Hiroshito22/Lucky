<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntecedentesOcularesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedentes_oculares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antecedentes_oftalmologias_id')->nullable()->references('id')->on('antecedentes_oftalmologias');
            $table->foreignId('enfermedades_oculares_id')->nullable()->references('id')->on('enfermedades_oculares');
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
        Schema::dropIfExists('antecedentes_oculares');
    }
}
