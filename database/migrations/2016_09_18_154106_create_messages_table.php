<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('creator_id')->unsigned()->index()->nullable();
			$table->integer('conversation_id')->unsigned()->index();
			$table->text('content');
            $table->timestamps();
        });

		Schema::table('messages', function (Blueprint $table) {
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('messages');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
