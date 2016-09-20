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
        Schema::dropIfExists('criteria');
    }
}
