<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnterioresEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anteriores_empresas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_psicologica_ocupacional_id')->nullable()->references('id')->on('ficha_psicologica_ocupacional');
            $table->date('fecha')->nullable();
            $table->string('nombre_empresa')->nullable();
            $table->string('actividad_empresa')->nullable();
            $table->string('puesto')->nullable();
            $table->string('causa_retiro')->nullable();
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
        Schema::dropIfExists('anteriores_empresas');
    }
}
