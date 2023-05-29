<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegmentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segmento', function (Blueprint $table) {
            $table->id();
            $table->string('parpados')->nullable();
            $table->string('conjuntiva')->nullable();
            $table->string('cornea')->nullable();
            $table->string('camara_anterior')->nullable();
            $table->string('iris')->nullable();
            $table->string('cristalino')->nullable();
            $table->string('refle_pupilares')->nullable();
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
        Schema::dropIfExists('segmento');
    }
}
