<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
            $table->foreignId('hospital_id')->nullable()->references('id')->on('hospital');
            $table->foreignId('vehiculo_id')->nullable()->references('id')->on('vehiculo');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
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
        Schema::dropIfExists('personal');
    }
}
