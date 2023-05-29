<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHojaRutaDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_ruta_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoja_ruta_id')->nullable()->references('id')->on('hoja_ruta');
            $table->foreignId('area_medica_id')->nullable()->references('id')->on('area_medica');
            $table->foreignId('capacitacion_id')->nullable()->references('id')->on('capacitacion');
            $table->foreignId('examen_id')->nullable()->references('id')->on('examen');
            $table->foreignId('laboratorio_id')->nullable()->references('id')->on('laboratorio');
            $table->foreignId('estado_ruta_id')->nullable()->references('id')->on('estado_ruta');
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
        Schema::dropIfExists('hoja_ruta_detalle');
    }
}
