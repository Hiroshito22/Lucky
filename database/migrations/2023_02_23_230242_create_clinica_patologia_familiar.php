<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaPatologiaFamiliar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica_patologia_familiar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antecedente_familiar_id')->nullable()->references('id')->on('antecedente_familiar');
            $table->foreignId('patologia_id')->nullable()->references('id')->on('patologia');
            $table->foreignId('familiar_id')->nullable()->references('id')->on('familiar');
            $table->string('comentario')->nullable();
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
        Schema::dropIfExists('clinica_patologia_familiar');
    }
}
