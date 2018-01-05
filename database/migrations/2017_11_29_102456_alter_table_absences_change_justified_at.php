<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAbsencesChangeJustifiedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropColumn('justified_at');
        });
        Schema::table('absences', function (Blueprint $table) {
            $table->dateTime('justified_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::disableForeignKeyConstraints();
	    Schema::table('absences', function (Blueprint $table) {
		    $table->dropColumn('justified_at');
	    });
	    Schema::table('absences', function (Blueprint $table) {
		    $table->time('justified_at')->nullable()->default(null);
	    });
	    Schema::enableForeignKeyConstraints();
    }
}
