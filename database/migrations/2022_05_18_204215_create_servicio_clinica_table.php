<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioClinicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_clinica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->nullable()->references('id')->on('servicio');
            // $table->foreignId('servicio_id')->nullable();
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            // $table->foreignId('clinica_id')->nullable();
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
        Schema::dropIfExists('servicio_clinica');
    }
}
