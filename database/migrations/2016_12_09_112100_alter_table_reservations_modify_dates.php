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
		Schema::disableForeignKeyConstraints();

		Schema::table('reservations', function (Blueprint $table) {
			$table->dropForeign('reservations_recurrence_id_index');
			$table->dropIndex('recurrence_id');
			$table->dropColumn('recurrence_id');
		});
		Schema::table('reservations', function (Blueprint $table) {
			$table->dropColumn('start_at');
		});
		Schema::table('reservations', function (Blueprint $table) {
			$table->dropColumn('end_at');
		});

        Schema::table('reservations', function (Blueprint $table) {
			//$table->dropForeign(['recurrence_id']);
            //$table->dropColumn('recurrence_id');
            //$table->dropColumn('start_at');
            //$table->dropColumn('end_at');

			$table->time('time_start')->default('');
			$table->time('time_end')->default('');
			$table->enum('day', ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'])->default('');
			$table->date('date_start')->default('');
			$table->date('date_end')->default('');
        });
		Schema::enableForeignKeyConstraints();
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
