<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('entidad_pago', function (Blueprint $table) {
                $table->id();
                $table->double('numero_cuenta')->nullable();
                $table->double('cci')->nullable();
                $table->char('estado_registro')->default('A');
                $table->foreignId('entidad_bancaria_id')->nullable()->references('id')->on('entidad_bancaria');
                $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
                $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
                $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
                $table->foreignId('user_rol_id')->nullable()->references('id')->on('users_rol');
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
        Schema::dropIfExists('entidad_pago');
    }
}
