<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')->nullable()->references('id')->on('tipo_documento');
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
            // $table->foreignId('user_rol_id')->nullable()->references('id')->on('user_rol');
            $table->string('razon_social')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('responsable')->nullable();
            $table->string('nombre_comercial')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('direccion')->nullable();
            $table->string('logo')->nullable();
            $table->char('estado_pago')->default('A');
            //$table->foreignId('hospital_id')->nullable()->references('id')->on('hospital');
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
        Schema::dropIfExists('clinica');
    }
}
