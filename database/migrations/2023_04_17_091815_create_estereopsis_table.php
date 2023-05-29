<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstereopsisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estereopsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stereo_fly_test_id')->nullable()->references('id')->on('stereo_fly_test');
            $table->foreignId('circulos_id')->nullable()->references('id')->on('circulos');
            $table->string('movimiento_ocular_tropias')->nullable();
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
        Schema::dropIfExists('estereopsis');
    }
}
