<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalFamiliar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_familiar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('famiiar_id')->nullable()->references('id')->on('familiar');
            $table->foreignId('hospital_id')->nullable()->references('id')->on('hospital');
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
        Schema::dropIfExists('hospital_familiar');
    }
}
