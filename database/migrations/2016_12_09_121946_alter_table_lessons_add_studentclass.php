<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableLessonsAddStudentclass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->integer('student_class_id')->unsigned()->index()->nullable();
        });

		Schema::table('lessons', function (Blueprint $table) {
            $table->foreign('student_class_id')->references('id')->on('student_classes')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['recurrence_id']);
            $table->dropIndex('recurrence_id');
            $table->dropColumn('recurrence_id');
        });
    }
}
