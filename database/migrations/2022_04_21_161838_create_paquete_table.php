<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquete', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->float('precio',8,2)->nullable();
            $table->char('estado_delivery')->default('1')->nullable();
            $table->char('estado_registro')->default('A');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
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
        Schema::dropIfExists('paquete');
    }
}
