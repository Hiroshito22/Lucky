<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidacionDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacion_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liquidacion_id')->nullable()->references('id')->on('liquidacion');
            $table->foreignId('atencion_id')->nullable()->references('id')->on('atencion');
            $table->double("total",8,2)->default('0.00')->nullable();
            $table->double("subtotal",8,2)->default('0.00')->nullable();
            $table->double("igv",8,2)->default('0.00')->nullable();
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
        Schema::dropIfExists('liquidacion_detalle');
    }
}
