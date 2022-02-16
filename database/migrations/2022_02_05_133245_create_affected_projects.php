<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffectedProjects extends Migration
{
    public function up()
    {
        Schema::create('affected_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note');
            $table->string('fichier');
            $table->integer('projet_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('affected_projects', function (Blueprint $table) {
            $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('affected_projects');
    }
}
