<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAlertsAddPreviousStudentValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alerts', function (Blueprint $table) {
	        $table->double('previous_student_value', 15, 2)->nullable();

	        $table->dropColumn('class_value');
        });

	    Schema::table('alerts', function (Blueprint $table) {
		    $table->double('class_value', 15, 2)->nullable();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alerts', function (Blueprint $table) {
	        $table->dropColumn('previous_student_value');
	        $table->dropColumn('class_value');
        });

	    Schema::table('alerts', function (Blueprint $table) {
		    $table->double('class_value', 15, 2);
	    });
    }
}
