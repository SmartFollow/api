<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProcessUserAddStepFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('process_user', function (Blueprint $table) {
        	$table->integer('step_id')->unsigned()->index()->nullable();
            $table->timestamps();
        });

	    Schema::table('process_user', function (Blueprint $table) {
		    $table->foreign('step_id')->references('id')->on('steps')->onDelete('set null')->onUpdate('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('process_user', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
