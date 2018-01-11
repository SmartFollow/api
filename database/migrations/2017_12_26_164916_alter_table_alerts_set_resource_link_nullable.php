<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAlertsSetResourceLinkNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn('resource_link');
        });
        Schema::table('alerts', function (Blueprint $table) {
            $table->string('resource_link')->nullable();
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
		    $table->dropColumn('resource_link');
	    });
	    Schema::table('alerts', function (Blueprint $table) {
		    $table->string('resource_link');
	    });
    }
}
