<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('hospital_id')->nullable()->references('id')->on('hospital');
            $table->foreignId('particular_id')->nullable()->references('id')->on('persona');
            $table->double("total",8,2)->default('0.00')->nullable();
            $table->double("subtotal",8,2)->default('0.00')->nullable();
            $table->double("igv",8,2)->default('0.00')->nullable();
            $table->char('estado_registro')->default('A');
            $table->integer('estado_pago')->default(0);
            $table->string('factura')->nullable();
            $table->text('observaciones')->nullable();
            $table->date('fecha_emision')->nullable();
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
        Schema::dropIfExists('liquidacion');
    }
}
