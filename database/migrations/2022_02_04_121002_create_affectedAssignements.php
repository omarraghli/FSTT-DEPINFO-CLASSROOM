<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffectedAssignements extends Migration
{
    public function up()
    {
        Schema::create('affected_assignements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note');
            $table->string('fichier');
            $table->integer('id_assignement')->unsigned();
            $table->integer('id_student')->unsigned();
            $table->timestamps();
        });

        Schema::table('affected_assignements', function (Blueprint $table) {
            $table->foreign('id_assignement')->references('id')->on('assignments')->onDelete('cascade');
            $table->foreign('id_student')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('affected_assignements');
    }
}
