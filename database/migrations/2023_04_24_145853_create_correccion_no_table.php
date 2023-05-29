<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreccionNoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correccion_no', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vision_lejos_id')->nullable()->references('id')->on('vision_lejos');
            $table->foreignId('vision_cerca_id')->nullable()->references('id')->on('vision_cerca');
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
        Schema::dropIfExists('correccion_no');
    }
}
