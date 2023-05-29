<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntecedenteGinecologicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_ginecologico', function (Blueprint $table) {
            $table->id();
            $table->date('fur')->nullable();
            $table->string('rc')->nullable();
            $table->date('fup')->nullable();
            $table->string('menarquia')->nullable();
            $table->date('ultimopap')->nullable();
            $table->char('estado')->nullable();
            $table->foreignId('mamografia_id')->nullable()->references('id')->on('mamografia');
            $table->foreignId('gestaciones_id')->nullable()->references('id')->on('gestaciones');
            $table->string('metodos_anticonceptivos')->nullable();
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
        Schema::dropIfExists('antecedente_ginecologico');
    }
}
