<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');
			$table->enum('type', ['warning', 'success', 'danger', 'info'])->nullable();
			$table->string('resource_link');
			$table->integer('criterion_id')->unsigned()->index();
			$table->integer('student_id')->unsigned()->index();
			$table->double('student_value', 15, 2);
			$table->double('class_value', 15, 2);
            $table->timestamps();
        });

		Schema::table('alerts', function (Blueprint $table) {
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
        Schema::dropIfExists('alerts');
    }
}
