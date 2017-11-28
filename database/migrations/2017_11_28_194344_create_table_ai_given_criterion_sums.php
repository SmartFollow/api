<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAiGivenCriterionSums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_given_criterion_sums', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('teacher_id')->unsigned()->index();
	        $table->integer('criterion_id')->unsigned()->index();
	        $table->decimal('sum')->nullable();
	        $table->date('week_start');
	        $table->date('week_end');
	        $table->integer('week');
	        $table->integer('year');
	        $table->timestamps();

	        $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
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
	    Schema::disableForeignKeyConstraints();
	    Schema::dropIfExists('ai_given_criterion_sums');
	    Schema::enableForeignKeyConstraints();
    }
}
