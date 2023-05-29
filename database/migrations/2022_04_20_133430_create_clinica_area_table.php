<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica_area', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->char('estado_registro')->default('A')->nullable();
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->foreignId('bregma_local_id')->nullable()->references('id')->on('bregma_local');
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('clinica_local_id')->nullable()->references('id')->on('clinica_local');
            $table->unsignedBigInteger('parent_id')->nullable();

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
        Schema::dropIfExists('clinica_area');
    }
}
