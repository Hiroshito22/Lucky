<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreoInstitucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correo_institucion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->string('correo')->nullable();
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
        Schema::dropIfExists('correo_institucion');
    }
}
