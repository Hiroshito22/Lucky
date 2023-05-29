<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoFamiliarPatologia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fo_familiar_patologia', function (Blueprint $table) {
            $table->id();
            $table->string('observaciones')->nullable();
            $table->foreignId('patologia_id')->nullable()->references('id')->on('patologia');
            $table->foreignId('fo_a_familiar_id')->nullable()->references('id')->on('fo_a_familiar');
            $table->foreignId('hospital_patologia_id')->nullable()->references('id')->on('hospital_patologia');
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
        Schema::dropIfExists('fo_familiar_patologia');
    }
}
