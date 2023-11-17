<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_detalle', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_entrada')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->string('codigo')->nullable();
            $table->integer('cantidad')->nullable();
            $table->foreignId('producto_id')->nullable()->references('id')->on('producto');
            $table->foreignId('marca_id')->nullable()->references('id')->on('marca');
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
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
        Schema::dropIfExists('producto_detalle');
    }
}
