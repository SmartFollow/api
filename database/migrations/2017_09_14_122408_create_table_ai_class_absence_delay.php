<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAiClassAbsenceDelay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_class_absence_delay', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('student_class_id')->unsigned()->index();
	        $table->integer('absences')->default(0);
	        $table->integer('delays')->default(0);
	        $table->date('week_start');
	        $table->date('week_end');
	        $table->integer('week');
	        $table->integer('year');
	        $table->timestamps();

	        $table->foreign('student_class_id')->references('id')->on('student_classes')->onDelete('cascade');
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
	    Schema::dropIfExists('ai_class_absence_delay');
	    Schema::enableForeignKeyConstraints();
    }
}
