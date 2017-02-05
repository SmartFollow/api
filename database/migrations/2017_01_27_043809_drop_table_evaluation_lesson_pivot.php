<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableEvaluationLessonPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::drop('evaluation_lesson');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('evaluation_lesson', function (Blueprint $table) {
            $table->integer('evaluation_id')->unsigned()->index();
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
            $table->integer('lesson_id')->unsigned()->index();
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->primary(['evaluation_id', 'lesson_id']);
        });
    }
}
