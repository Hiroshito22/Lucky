<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaPatologiaPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica_patologia_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antecedente_personal_id')->nullable()->references('id')->on('antecedente_personal');
            $table->foreignId('clinica_patologia_id')->nullable()->references('id')->on('clinica_patologia');
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
        Schema::dropIfExists('clinica_patologia_personal');
    }
}
