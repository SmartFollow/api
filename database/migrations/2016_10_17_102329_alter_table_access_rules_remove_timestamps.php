<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAccessRulesRemoveTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_rules', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
		Schema::table('access_rules', function (Blueprint $table) {
            $table->dropColumn('updated_at');
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
        Schema::table('access_rules', function (Blueprint $table) {
            $table->timestamps();
        });
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
