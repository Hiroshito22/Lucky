<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_paquete_id')->nullable()->references('id')->on('clinica_paquete');
            // $table->foreignId('entrada_id')->nullable()->references('id')->on('perfil_tipo');
            // $table->foreignId('rutina_id')->nullable()->references('id')->on('perfil_tipo');
            // $table->foreignId('salida_id')->nullable()->references('id')->on('perfil_tipo');
            $table->string('nombre')->nullable();
            $table->double('precio')->nullable();
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
        Schema::dropIfExists('perfil');
    }
}
