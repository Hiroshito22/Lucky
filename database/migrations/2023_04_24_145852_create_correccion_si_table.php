<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreccionSiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correccion_si', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vision_lejos_id')->nullable()->references('id')->on('vision_lejos');
            $table->foreignId('vision_cerca_id')->nullable()->references('id')->on('vision_cerca');
            $table->char('esatdo_registro')->default('A');
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
        Schema::dropIfExists('correccion_si');
    }
}
