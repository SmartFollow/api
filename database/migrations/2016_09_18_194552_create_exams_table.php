<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('lesson_id')->unsigned()->index();
			$table->enum('type', ['home', 'class', 'surprise'])->nullable();
			$table->string('description');
			$table->integer('min_mark')->default(0);
			$table->integer('max_mark')->default(20);
			$table->string('path_to_subject')->nullable();
            $table->timestamps();
        });

		Schema::table('exams', function (Blueprint $table) {
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('exams');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
