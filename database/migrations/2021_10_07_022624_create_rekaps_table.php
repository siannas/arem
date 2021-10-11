<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_formulir')->unsigned();
            $table->integer('id_sekolah')->unsigned();
            $table->json('json');
            $table->foreign('id_formulir')->references('id')->on('formulir');
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
        Schema::dropIfExists('rekap');
    }
}
