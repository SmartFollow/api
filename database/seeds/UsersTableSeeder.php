<?php

use Illuminate\Database\Seeder;

use App\Models\Users\Group;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(App\Models\Users\User::class, 150)->create();

		$teachers = User::take(10)->get();
		foreach ($teachers as $teacher)
		{
			$teacher->group()->associate(Group::where('name', 'Professeurs')->first());
			$teacher->class_id = null;
			$teacher->save();
		}

		$admin = User::first();
	    $admin->group()->associate(Group::where('name', 'Administrateurs')->first());
	    $admin->class_id = null;
	    $admin->save();
    }
}
