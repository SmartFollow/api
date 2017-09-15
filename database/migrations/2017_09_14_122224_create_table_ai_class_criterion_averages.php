<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAiClassCriterionAverages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_class_criterion_averages', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('student_class_id')->unsigned()->index();
	        $table->integer('criterion_id')->unsigned()->index();
	        $table->decimal('average')->nullable();
	        $table->date('week_start');
	        $table->date('week_end');
	        $table->integer('week');
	        $table->integer('year');
	        $table->timestamps();

	        $table->foreign('student_class_id')->references('id')->on('student_classes')->onDelete('cascade');
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
	    Schema::dropIfExists('ai_class_criterion_averages');
	    Schema::enableForeignKeyConstraints();
    }
}
