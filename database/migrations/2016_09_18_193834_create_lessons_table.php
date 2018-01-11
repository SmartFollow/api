<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('subject_id')->unsigned()->index();
			$table->integer('reservation_id')->unsigned()->index()->nullable();
			$table->string('description');
            $table->timestamps();
			$table->softDeletes();
        });

		Schema::table('lessons', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('lessons');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
