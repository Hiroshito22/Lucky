<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtencionServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atencion_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId("servicio_id")->nullable()->references('id')->on('servicio');
            $table->foreignId("atencion_id")->nullable()->references('id')->on('atencion');
            $table->integer('estado_atencion')->default(0);
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->char('estado_registro')->default("A");
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
        Schema::dropIfExists('atencion_servicio');
    }
}
