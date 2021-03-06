<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_rules', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('route');
			$table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('access_rules');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
