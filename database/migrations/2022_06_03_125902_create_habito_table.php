<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habito', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_habito_id')->nullable()->references('id')->on('tipo_habito');
            $table->foreignId('frecuencia_id')->nullable()->references('id')->on('frecuencia');
            $table->foreignId('habito_nocivo_id')->nullable()->references('id')->on('habito_nocivo');
            $table->string('frecuencia')->nullable();
            $table->string('tiempo')->nullable();
            $table->string('tipo')->nullable();
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
        Schema::dropIfExists('habito');
    }
}
