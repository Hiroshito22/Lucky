<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicaPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinica_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_area_id')->nullable()->references('id')->on('clinica_area');
            $table->foreignId('rol_id')->nullable()->references('id')->on('rol');
            $table->foreignId('clinica_id')->nullable()->references('id')->on('clinica');
            $table->foreignId('user_rol_id')->nullable()->references('id')->on('users_rol');
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
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
        Schema::dropIfExists('clinica_personal');
    }
}
