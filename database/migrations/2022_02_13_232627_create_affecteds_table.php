<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffectedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affecteds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fichier');
            $table->integer('project_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('affecteds', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        //
    }
}
