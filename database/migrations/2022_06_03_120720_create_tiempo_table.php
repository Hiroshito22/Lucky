<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiempoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiempo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_tiempo_id')->nullable()->references('id')->on('tipo_tiempo');
            $table->string('cantidad')->nullable();
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
        Schema::dropIfExists('tiempo');
    }
}
