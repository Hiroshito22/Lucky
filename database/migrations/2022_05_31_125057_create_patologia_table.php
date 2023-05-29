<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatologiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patologia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_patologia_id')->nullable()->references('id')->on('tipo_patologia');
            $table->string('nombre')->nullable();
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
        Schema::dropIfExists('patologia');
    }
}
