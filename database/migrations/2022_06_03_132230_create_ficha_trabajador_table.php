<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaTrabajadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficha_trabajador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_ocupacional_id')->nullable()->references('id')->on('ficha_ocupacional');
            $table->foreignId('ficha_psicologica_ocupacional_id')->nullable()->references('id')->on('ficha_psicologica_ocupacional');
            $table->foreignId('trabajador_id')->nullable()->references('id')->on('trabajador');
            $table->string('nombres')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->integer('numero_documento')->nullable();
            $table->foreignId('tipo_documento_id')->nullable()->references('id')->on('tipo_documento');
            $table->integer('hijos_vivos')->nullable();
            $table->integer('dependientes')->nullable();
            $table->string('direccion')->nullable();
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
            $table->string('residencia_lugar_trabajo')->nullable();
            $table->time('tiempo_residencia')->nullable();
            $table->foreignId('grado_instruccion_id')->nullable()->references('id')->on('grado_instruccion');
            $table->integer('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('ficha_trabajador');
    }
}
