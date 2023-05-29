<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadBancariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('entidad_bancaria', function (Blueprint $table) {
                $table->id();
                $table->string('nombre')->nullable();
                $table->string('logo')->nullable();
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
        Schema::dropIfExists('persona_entidad_pago');
    } 
}
