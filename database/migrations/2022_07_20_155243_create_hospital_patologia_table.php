<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalPatologiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_patologia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patologia_id')->nullable()->references('id')->on('patologia');
            $table->foreignId('hospital_id')->nullable()->references('id')->on('hospital');
            $table->integer('activo')->default(1);
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
        Schema::dropIfExists('hospital_patologia');
    }
}
