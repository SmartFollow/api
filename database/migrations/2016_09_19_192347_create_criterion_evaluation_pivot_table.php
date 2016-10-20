<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriterionEvaluationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterion_evaluation', function (Blueprint $table) {
            $table->integer('criterion_id')->unsigned()->index();
            $table->foreign('criterion_id')->references('id')->on('criteria')->onDelete('cascade');
            $table->integer('evaluation_id')->unsigned()->index();
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
            $table->primary(['criterion_id', 'evaluation_id']);

			$table->json('value')->nullable();
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
        Schema::drop('criterion_evaluation');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
