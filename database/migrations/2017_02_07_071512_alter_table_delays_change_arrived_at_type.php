<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDelaysChangeArrivedAtType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delays', function (Blueprint $table) {
            $table->time('arrived_at')->nullable()->change();
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
        Schema::table('delays', function (Blueprint $table) {
            $table->time('arrived_at')->nullable()->change();
        });
	    Schema::enableForeignKeyConstraints();
    }
}
