<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtencionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atencion', function (Blueprint $table) {
            $table->id();
            $table->foreignId("trabajador_id")->nullable()->references('id')->on('trabajador');
            $table->foreignId("persona_id")->nullable()->references('id')->on('persona');
            $table->foreignId("empresa_id")->nullable()->references('id')->on('empresa');
            $table->foreignId("paquete_id")->nullable()->references('id')->on('paquete');
            $table->foreignId("tipo_evaluacion_id")->nullable()->references('id')->on('tipo_evaluacion');
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_atencion')->nullable();
            $table->char('estado_atencion')->nullable();
            $table->integer('tipo_atencion')->default(0)->nullable();
            $table->char('estado_registro')->default('A');
            $table->double("total",8,2)->default('0.00')->nullable();
            $table->double("subtotal",8,2)->default('0.00')->nullable();
            $table->double("igv",8,2)->default('0.00')->nullable();
            $table->foreignId("hospital_id")->nullable()->references('id')->on('hospital');
            $table->foreignId("sucursal_hospital_id")->nullable()->references('id')->on('sucursal');
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
        Schema::dropIfExists('atencion');
    }
}
