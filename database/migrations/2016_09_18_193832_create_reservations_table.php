<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('room_id')->unsigned()->index();
			$table->timestamp('start_at')->nullable();
			$table->timestamp('end_at')->nullable();
			$table->integer('recurrence_id')->unsigned()->index()->nullable();
            $table->timestamps();
        });

		Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('recurrence_id')->references('id')->on('recurrences')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('reservations');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
