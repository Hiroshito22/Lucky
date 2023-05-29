<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('datos_ekg_id')->nullable()->references('id')->on('datos_ekg');
            //$table->foreignId('preguntas_ekg_id')->nullable()->references('id')->on('preguntas_ekg');
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
        Schema::dropIfExists('ekg');
    }
}
