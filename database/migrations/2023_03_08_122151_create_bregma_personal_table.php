<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBregmaPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bregma_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bregma_area_id')->nullable()->references('id')->on('bregma_area');
            $table->foreignId('rol_id')->nullable()->references('id')->on('rol');
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
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
        Schema::dropIfExists('bregma_personal');
    }
}
