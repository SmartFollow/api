<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAiStudentCriterionAveragesAddWeek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_student_criterion_averages', function (Blueprint $table) {
            $table->integer('week');
            $table->integer('year');
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
        Schema::table('ai_student_criterion_averages', function (Blueprint $table) {
            $table->dropColumn('week');
            $table->dropColumn('year');
        });
	    Schema::enableForeignKeyConstraints();
    }
}
