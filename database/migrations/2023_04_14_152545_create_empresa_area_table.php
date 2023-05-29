<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_area', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->integer('numero_trabajadores')->nullable();
            $table->foreignId('empresa_local_id')->nullable()->references('id')->on('empresa_local');
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->unsignedBigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('empresa_area');
    }
}
