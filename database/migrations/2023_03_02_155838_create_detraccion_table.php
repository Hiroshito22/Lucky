<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetraccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detraccion', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cuenta')->nullable();
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('user_rol_id')->nullable()->references('id')->on('users_rol');
            $table->string('estado_registro', 2)->default('A');
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
        Schema::dropIfExists('detraccion');
    }
}
