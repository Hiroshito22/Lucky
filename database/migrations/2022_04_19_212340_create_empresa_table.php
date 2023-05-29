<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('ruc')->unique();
            $table->string('razon_social')->nullable();
            $table->string('responsable')->nullable();
            $table->string('nombre_comercial')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            //$table->foreignId('tipo_empresa_id')->nullable()->references('id')->on('tipo_empresa');
            $table->string('numero_documento')->nullable();
            $table->foreignId('tipo_documento_id')->nullable()->references('id')->on('tipo_documento');
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
            $table->string('direccion')->nullable();
            $table->string('ubicacion_mapa')->nullable();
            $table->date('aniversario')->nullable();
            $table->foreignId('rubro_id')->nullable()->references('id')->on('rubro');
            $table->integer('cantidad_trabajadores')->nullable();
            $table->integer('años_actividad')->nullable();
            $table->string('logo')->nullable();
            // $table->foreignId('hospital_id')->nullable()->references('id')->on('hospital');
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
        Schema::dropIfExists('empresa');
    }
}
