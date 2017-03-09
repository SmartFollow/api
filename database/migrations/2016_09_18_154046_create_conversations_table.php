<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('creator_id')->unsigned()->index()->nullable();
			$table->string('subject');
			$table->softDeletes();
            $table->timestamps();
        });

		Schema::table('conversations', function (Blueprint $table) {
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('conversations');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
