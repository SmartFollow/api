<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableNotificationUserReadAtToDatetime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_user', function (Blueprint $table) {
	        $table->dateTime('read_at')->nullable()->change();
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
        Schema::table('notification_user', function (Blueprint $table) {
	        $table->time('read_at')->nullable()->change();
        });
	    Schema::enableForeignKeyConstraints();
    }
}
