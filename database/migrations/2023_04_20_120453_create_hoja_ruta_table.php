<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHojaRutaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_ruta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_personal_id')->nullable()->references('id')->on('empresa_personal');
            $table->foreignId('perfil_tipo_id')->nullable()->references('id')->on('perfil_tipo');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
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
        Schema::dropIfExists('hoja_ruta');
    }
}
