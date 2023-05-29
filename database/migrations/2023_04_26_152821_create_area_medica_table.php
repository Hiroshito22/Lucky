<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaMedicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_medica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->string('nombre')->nullable();
            $table->string('icono')->nullable();
            $table->double('precio_referencial')->nullable();
            $table->double('precio_mensual')->nullable();
            $table->double('precio_anual')->nullable();
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
        Schema::dropIfExists('area_medica');
    }
}
