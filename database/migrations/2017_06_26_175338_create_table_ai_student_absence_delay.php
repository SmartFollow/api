<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAiStudentAbsenceDelay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_student_absence_delay', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('user_id')->unsigned()->index();
	        $table->integer('absences')->default(0);
	        $table->integer('delays')->default(0);
	        $table->date('week_start');
	        $table->date('week_end');
	        $table->integer('week');
	        $table->integer('year');
            $table->timestamps();

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
	    Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ai_student_absence_delay');
	    Schema::enableForeignKeyConstraints();
    }
}
