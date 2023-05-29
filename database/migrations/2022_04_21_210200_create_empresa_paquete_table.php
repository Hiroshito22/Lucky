<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaPaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_paquete', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('paquete_id')->nullable()->references('id')->on('paquete');
            $table->float('precio',8,2)->nullable();
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
        Schema::dropIfExists('empresa_paquete');
    }
}
