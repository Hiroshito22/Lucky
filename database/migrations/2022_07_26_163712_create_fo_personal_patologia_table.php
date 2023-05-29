<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoPersonalPatologiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fo_personal_patologia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patologia_id')->nullable()->references('id')->on('patologia');
            $table->foreignId('fo_a_personal_id')->nullable()->references('id')->on('fo_a_personal');
            $table->foreignId('hospital_patologia_id')->nullable()->references('id')->on('hospital_patologia');
            $table->char('estado_registro')->default('A');
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('fo_personal_patologia');
    }
}
