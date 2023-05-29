<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportistaMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportista_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transportista_id')->nullable()->references('id')->on('personal');
            $table->foreignId('material_id')->nullable()->references('id')->on('material');
            $table->double('cantidad_disponible')->nullable();
            $table->double('cantidad_asignada')->nullable();
            $table->double('cantidad_recojo')->nullable();
            $table->date('fecha')->nullable();
            $table->char('estado_recepcion')->default('0');
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
        Schema::dropIfExists('transportista_material');
    }
}
