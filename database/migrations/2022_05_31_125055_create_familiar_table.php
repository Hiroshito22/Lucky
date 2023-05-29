<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familiar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antecedente_familiar_id')->nullable()->references('id')->on('antecedente_familiar');
            $table->foreignId('tipo_familiar_id')->nullable()->references('id')->on('tipo_familiar');
            // $table->string('nombre')->nullable();
            // $table->string('apellido_paterno')->nullable();
            // $table->string('apellido_materno')->nullable();
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
        Schema::dropIfExists('familiar');
    }
}
