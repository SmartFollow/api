<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->increments('id');
			$table->string('description');
			$table->integer('lesson_id')->unsigned()->index();
			$table->integer('document_id')->unsigned()->index()->nullable();
            $table->timestamps();
        });

		Schema::table('homeworks', function (Blueprint $table) {
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('homeworks');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
