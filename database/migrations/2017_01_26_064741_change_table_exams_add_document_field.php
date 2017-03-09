<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableExamsAddDocumentField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('path_to_subject');
			
			$table->integer('document_id')->unsigned()->index()->nullable();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('set null');
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
			$table->dropForeign(['document_id']);
            $table->dropIndex('document_id');
			$table->dropIndex('document_id');

            $table->string('path_to_subject')->nullable();
        });
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
