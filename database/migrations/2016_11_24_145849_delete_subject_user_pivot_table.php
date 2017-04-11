<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSubjectUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::drop('subject_user');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('subject_user', function (Blueprint $table) {
            $table->integer('subject_id')->unsigned()->index();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['subject_id', 'user_id']);
        });
    }
}
