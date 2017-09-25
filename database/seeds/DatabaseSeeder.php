<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccessRulesSeeder::class);
        $this->call(GroupsTableSeeder::class);
	    $this->call(LevelsTableSeeder::class);
	    $this->call(StudentClassesTableSeeder::class);
	    $this->call(UsersTableSeeder::class);
	    $this->call(SubjectsTableSeeder::class);
        $this->call(CriteriaTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
    }
}
