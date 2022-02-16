<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjets extends Migration
{
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('due_date');
            $table->string('type');
            $table->string('fichier');
            $table->integer('teacher_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('projets', function (Blueprint $table) {
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projets');
    }
}
