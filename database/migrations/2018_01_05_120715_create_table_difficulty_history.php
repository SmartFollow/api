<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDifficultyHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('difficulty_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned()->index();
	        $table->integer('week');
	        $table->integer('year');
            $table->timestamps();

	        $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
	        $table->unique(['student_id', 'week', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('difficulty_history');
    }
}
