<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')->nullable();
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('marca_id')->nullable()->references('id')->on('marca');
            $table->foreignId('unidad_medida_id')->nullable()->references('id')->on('unidad_medida');
            $table->string('foto')->nullable();
            $table->integer('cantidad')->nullable();
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
        Schema::dropIfExists('producto');
    }
}
