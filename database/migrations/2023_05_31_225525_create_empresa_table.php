<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social')->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('distrito_id')->nullable()->references('id')->on('distritos');
            $table->foreignId('gerente_id')->nullable()->references('id')->on('gerente');
            $table->foreignId('trabajador_id')->nullable()->references('id')->on('trabajador');
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
        Schema::dropIfExists('empresa');
    }
}
