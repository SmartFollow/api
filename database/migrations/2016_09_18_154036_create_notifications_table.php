<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('transmitter_id')->unsigned()->index()->nullable();
			$table->string('resource_link');
			$table->text('message');
            $table->timestamps();
			$table->softDeletes();
        });

		Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('transmitter_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('notifications');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
