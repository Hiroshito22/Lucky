<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')->nullable()->references('id')->on('tipo_documento');
            $table->string('numero_documento')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('logo')->nullable();
            $table->string('direccion')->nullable();
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
            $table->string('estado_pago')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
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
        Schema::dropIfExists('hospital');
    }
}
