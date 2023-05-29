<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_rol_id')->nullable()->references('id')->on('users_rol');
            $table->foreignId('lead_id')->nullable()->references('id')->on('lead');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
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
        Schema::dropIfExists('estado_venta');
    }
}
