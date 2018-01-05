<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDifficultiesNullableTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('difficulties', function (Blueprint $table) {
	        $table->integer('assigned_teacher_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('difficulties', function (Blueprint $table) {
	        $table->integer('assigned_teacher_id')->unsigned()->change();
        });
    }
}
