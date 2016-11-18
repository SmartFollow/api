<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->enum('impact', ['neutral', 'positive', 'negative'])->default('neutral');
			$table->integer('difference_limit_percentage')->default();
			$table->integer('check_interval')->comment('in seconds');
			$table->enum('stats_type', ['sum', 'average'])->nullable();
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
        Schema::dropIfExists('criteria');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
