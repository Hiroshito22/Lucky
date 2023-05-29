<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorialBregmaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorial_bregma', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('link')->nullable();
            $table->foreignId('bregma_id')->nullable()->references('id')->on('bregma');
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
        Schema::dropIfExists('tutorial_bregma');
    }
}
