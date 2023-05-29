<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subarea', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->char('estado_registro')->default('A')->nullable();
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('area_id')->nullable()->references('id')->on('area');
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
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
        Schema::dropIfExists('subarea');
    }
}
