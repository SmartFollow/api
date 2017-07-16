<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableRecurrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('recurrences');
		Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::disableForeignKeyConstraints();
        Schema::create('recurrences', function (Blueprint $table) {
            $table->increments('id');
			$table->timestamp('start')->nullable();
			$table->timestamp('end')->nullable();
            $table->timestamps();
        });
	    Schema::enableForeignKeyConstraints();
    }
}
