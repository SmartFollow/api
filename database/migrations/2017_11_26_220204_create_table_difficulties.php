<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDifficulties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('difficulties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned()->index();
            $table->integer('assigned_teacher_id')->unsigned()->index();
	        $table->integer('week');
	        $table->integer('year');
            $table->timestamps();

	        $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
	        $table->foreign('assigned_teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::disableForeignKeyConstraints();
	    Schema::dropIfExists('difficulties');
	    Schema::enableForeignKeyConstraints();
    }
}
