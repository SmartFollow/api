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
			$table->dropIndex('recurrence_id');
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
        Schema::table('reservations', function (Blueprint $table) {
            //
        });
    }
}
