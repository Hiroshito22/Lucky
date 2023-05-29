<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestaciones', function (Blueprint $table) {
            $table->id();
            $table->string('gestaciones')->nullable();
            $table->string('abortos')->nullable();
            $table->string('partos')->nullable();
            $table->string('p_prematuros')->nullable();
            $table->string('p_eutacico')->nullable();
            $table->string('p_distocias')->nullable();
            $table->string('cesareas')->nullable();
            $table->date('fecha_cesarea')->nullable();
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
        Schema::dropIfExists('gestaciones');
    }
}
