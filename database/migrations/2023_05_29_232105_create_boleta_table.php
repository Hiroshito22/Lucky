<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boleta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->nullable()->references('id')->on('producto');
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
            $table->string('cantidad')->nullable();
            $table->foreignId('tipo_boleta_id')->nullable()->references('id')->on('tipo_boleta');
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
        Schema::dropIfExists('boleta');
    }
}
