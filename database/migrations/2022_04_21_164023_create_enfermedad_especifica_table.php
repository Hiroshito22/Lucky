<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermedadEspecificaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermedad_especifica', function (Blueprint $table) {
            $table->id();
            $table->char('codigo')->unique();
            $table->string('enfermedad_especifica')->unique();
            $table->foreignId('enfermedad_general_id')->nullable()->references('id')->on('enfermedad_general');
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
        Schema::dropIfExists('enfermedad_especifica');
    }
}
