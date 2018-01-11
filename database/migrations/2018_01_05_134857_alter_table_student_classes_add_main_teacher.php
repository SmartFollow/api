<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStudentClassesAddMainTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_classes', function (Blueprint $table) {
	        $table->integer('main_teacher_id')->nullable()->unsigned()->index();

	        $table->foreign('main_teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_classes', function (Blueprint $table) {
	        $table->dropForeign(['main_teacher_id']);
	        $table->dropColumn('main_teacher_id');
        });
    }
}
