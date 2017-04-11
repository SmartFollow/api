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
		factory(App\Models\Users\User::class, 15)->create();

		$teachers = User::take(3)->get();
		foreach ($teachers as $teacher)
		{
			$teacher->group()->associate(Group::where('name', 'Teachers')->first());
			$teacher->save();
		}

		$user = User::first();
		$user->group_id = Group::where('name', 'Administrators')->first()->id;
		$user->save();
    }
}
