<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableReservationsModifyDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('reservations', function (Blueprint $table) {
			$table->dropForeign(['recurrence_id']);
            $table->dropColumn('recurrence_id');
            $table->dropColumn('start_at');
            $table->dropColumn('end_at');

			$table->time('time_start');
			$table->time('time_end');
			$table->enum('day', ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY']);
			$table->date('date_start');
			$table->date('date_end');
        });
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('reservations', function (Blueprint $table) {
			$table->dropColumn('time_start');
			$table->dropColumn('time_end');
			$table->dropColumn('day');
			$table->dropColumn('date_start');
			$table->dropColumn('date_end');

			$table->timestamp('start_at')->nullable();
			$table->timestamp('end_at')->nullable();
			$table->integer('recurrence_id')->unsigned()->index()->nullable();
        });

		Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('recurrence_id')->references('id')->on('recurrences')->onDelete('set null')->onUpdate('cascade');
        });

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
