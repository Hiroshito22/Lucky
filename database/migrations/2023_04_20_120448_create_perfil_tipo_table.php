<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilTipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_tipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfil_id')->nullable()->references('id')->on('perfil');
            // $table->foreignId('area_medica_id')->nullable()->references('id')->on('perfil');
            $table->foreignId('tipo_perfil_id')->nullable()->references('id')->on('tipo_perfil');
            $table->integer('precio')->nullable();
            $table->char('estado_registro')->default('A');
            // $table->double('precio')->nullable();
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
        Schema::dropIfExists('perfil_tipo');
    }
}
