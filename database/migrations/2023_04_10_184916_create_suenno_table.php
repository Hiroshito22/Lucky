<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuennoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suenno', function (Blueprint $table) {         // Resulta error con la letra "ñ" -> sueño
        $table->id();
        $table->string('nombre')->nullable();
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
        Schema::dropIfExists('suenno');
    }
}
