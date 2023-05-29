<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalCargoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_cargo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_id')->nullable()->references('id')->on('personal');
            $table->foreignId('cargo_id')->nullable()->references('id')->on('cargo');
            $table->foreignId('hospital_id')->nullable()->references('id')->on('hospital');
            $table->string('firma')->nullable();
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
        Schema::dropIfExists('personal_cargo');
    }
}
