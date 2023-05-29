<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilCapacitacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_capacitacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfil_tipo_id')->nullable()->references('id')->on('perfil_tipo');
            $table->foreignId('capacitacion_id')->nullable()->references('id')->on('capacitacion');
            $table->char('estado_registro')->default('A');
            //$table->string('nombre')->nullable();
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
        Schema::dropIfExists('perfil_capacitacion');
    }
}
