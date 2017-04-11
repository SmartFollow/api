<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableExamsSetDescriptionNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->enum('type', ['home', 'class', 'surprise'])->default('class');
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
		Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->string('description')->change();
			$table->enum('type', ['home', 'class', 'surprise'])->nullable();
        });
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
