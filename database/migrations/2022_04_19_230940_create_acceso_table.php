<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceso', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('tutorial_url')->nullable();
            $table->char('estado_registro')->default('A');
            $table->string('icon')->nullable();
            $table->string('label')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('tipo_acceso')->nullable(); // 1-bregma 2-clinica 3-empresa 4-clinicas asociadas 5-trabajador 6-particular
            $table->string('tipo')->nullable(); //0-adminsitrativo  1-operario
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
        Schema::dropIfExists('acceso');
    }
}
