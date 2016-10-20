<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('lesson_id')->unsigned()->index();
			$table->integer('student_id')->unsigned()->index();
			$table->string('comment');
            $table->timestamps();
        });

		Schema::table('evaluations', function (Blueprint $table) {
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('evaluations');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
