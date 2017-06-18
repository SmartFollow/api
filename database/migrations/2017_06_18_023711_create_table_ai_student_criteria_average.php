<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAiStudentCriteriaAverage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_student_criterion_averages', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('user_id')->unsigned()->index();
	        $table->integer('criterion_id')->unsigned()->index();
	        $table->decimal('average')->nullable();
	        $table->date('week_start');
	        $table->date('week_end');
            $table->timestamps();

	        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
	        $table->foreign('criterion_id')->references('id')->on('criteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ai_student_criterion_averages');
    }
}
