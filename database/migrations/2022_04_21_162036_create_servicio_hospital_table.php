<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioHospitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_hospital', function (Blueprint $table) {
            $table->id();
            $table->double('precio')->nullable();
            $table->foreignId('servicio_id')->nullable()->references('id')->on('servicio');
            $table->foreignId('hospital_id')->nullable()->references('id')->on('hospital');
            $table->char('estado_delivery')->default('1')->nullable();
            $table->char('estado')->default('1')->nullable();
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
        Schema::dropIfExists('servicio_hospital');
    }
}
