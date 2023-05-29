<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermedadGeneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermedad_general', function (Blueprint $table) {
            $table->id();
            $table->char('codigo')->unique();
            $table->string('enfermedad_general')->unique();
            $table->foreignId('enfermedad_id')->references('id')->on('enfermedad');
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
        Schema::dropIfExists('enfermedad_general');
    }
}
