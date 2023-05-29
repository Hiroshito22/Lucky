<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBregmaPaqueteAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bregma_paquete_area', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bregma_paquete_id')->nullable()->references('id')->on('bregma_paquete');
            $table->foreignId('area_medica_id')->nullable()->references('id')->on('area_medica');
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
        Schema::dropIfExists('bregma_paquete_area');
    }
}
