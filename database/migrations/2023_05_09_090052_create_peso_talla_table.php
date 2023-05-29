<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesoTallaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peso_talla', function (Blueprint $table) {
            $table->id();
            $table->foreignId('triaje_id')->nullable()->references('id')->on('triaje');
            $table->double('peso',8,2)->nullable();
            $table->double('talla',8,2)->nullable();
            $table->double('cintura',8,2)->nullable();
            $table->double('cadera',8,2)->nullable();
            $table->double('max_inspiracion',8,2)->nullable();
            $table->double('expiracion_forzada',8,2)->nullable();
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('peso_talla');
    }
}
