<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('groups')->insert([
			'name' => 'Administrators',
			'description' => 'Administrators of the software',
			'deletable' => false,
		]);

		DB::table('groups')->insert([
			'name' => 'Teachers',
			'description' => 'Teachers of the school',
			'deletable' => false,
		]);

		DB::table('groups')->insert([
			'name' => 'Employees',
			'description' => 'Administrators of the school',
			'deletable' => true,
		]);

		DB::table('groups')->insert([
			'name' => 'Students',
			'description' => 'Students of the school',
			'deletable' => false,
		]);
    }
}
