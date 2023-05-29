<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportistaVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportista_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transportista_id')->nullable()->references('id')->on('personal');
            $table->foreignId('vehiculo_id')->nullable()->references('id')->on('vehiculo');
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
        Schema::dropIfExists('transportista_vehiculo');
    }
}
