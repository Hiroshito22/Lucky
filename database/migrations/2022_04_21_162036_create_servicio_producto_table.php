<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_hospital_id')->nullable()->references('id')->on('servicio_hospital');
            $table->foreignId('producto_id')->nullable()->references('id')->on('producto');
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
        Schema::dropIfExists('servicio_producto');
    }
}
