<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntecedenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antecedente_personal_id')->nullable()->references('id')->on('antecedente_personal');
            $table->foreignId('tipo_antecedente_id')->nullable()->references('id')->on('tipo_antecedente');
            $table->string('asociado_trabajo')->nullable();
            $table->string('descripcion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->integer('dias_incapacidad')->nullable();
            $table->string('menoscabo')->nullable();
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
        Schema::dropIfExists('antecedente');
    }
}
