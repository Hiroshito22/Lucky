<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_area_id')->nullable()->references('id')->on('empresa_area');
            $table->foreignId('rol_id')->nullable()->references('id')->on('rol');
            $table->foreignId('empresa_id')->nullable()->references('id')->on('empresa');
            $table->foreignId('user_rol_id')->nullable()->references('id')->on('users_rol');
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona');
            $table->char('estado_reclutamiento')->default('0');
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
        Schema::dropIfExists('empresa_personal');
    }
}
