<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('id_role');
            $table->integer('parent')->unsigned()->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email');
            $table->string('telp');
            $table->rememberToken();
            $table->timestamps();
            $table->smallInteger('kelas')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('parent')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
