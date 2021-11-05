<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImunisasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imunisasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->date('tanggal');
            $table->string('vaksin',50);
            $table->string('dosis',2)->nullable();
            $table->string('nomor',20)->nullable();
            $table->string('nama',50)->nullable();
            $table->string('lokasi')->nullable();
            $table->string('bukti');
            $table->tinyInteger('validasi');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('imunisasi');
    }
}
