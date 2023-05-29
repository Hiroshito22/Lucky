<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoporteContactoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soporte_contacto', function (Blueprint $table) {
            $table->id();
            $table->string('celular1')->nullable();
            $table->string('celular2')->nullable();
            $table->string('correo1')->nullable();
            $table->string('correo2')->nullable();
            $table->string('telefono1')->nullable();
            $table->string('telefono2')->nullable();
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
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
        Schema::dropIfExists('soporte_contacto');
    }
}
