<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosEkgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_ekg', function (Blueprint $table) {
            $table->id();
            $table->string('ritmo')->nullable();
            $table->double('pr')->nullable();
            $table->string('frecuencia')->nullable();
            $table->double('qrs')->nullable();
            $table->integer('eje_electrico')->nullable();
            $table->double('qt')->nullable();
            $table->string('conclusiones')->nullable();
            $table->string('recomendaciones')->nullable();
            $table->string('medico_evaluador')->nullable();
            $table->string('colegiatura')->nullable();
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
        Schema::dropIfExists('datos_ekg');
    }
}
