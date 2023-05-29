<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
            $table->string('nombre')->nullable();
            $table->string('precio_referencial')->nullable();
            $table->string('precio_mensual')->nullable();
            $table->string('precio_anual')->nullable();
            $table->string('icono')->nullable();
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
        Schema::dropIfExists('laboratorio');
    }
}
