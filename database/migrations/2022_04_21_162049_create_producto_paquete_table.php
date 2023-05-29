<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoPaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_paquete', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->nullable()->references('id')->on('producto');
            $table->foreignId('paquete_id')->nullable()->references('id')->on('paquete');
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
        Schema::dropIfExists('producto_paquete');
    }
}
