<?php

use Illuminate\Database\Seeder;

use App\Models\Users\Group;
use App\Models\Users\AccessRule;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$administrators = Group::create([
			'name' => 'Administrators',
			'description' => 'Administrators of the software',
			'deletable' => false,
			'editable' => false,
		]);
		$administrators->accessRules()->attach(AccessRule::where('route', 'user.profile')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'user.show')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.index')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.create')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.store')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.show')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.edit')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.update')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.destroy')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.access-rules')->first());

		$teachers = Group::create([
			'name' => 'Teachers',
			'description' => 'Teachers of the school',
			'deletable' => false,
			'editable' => false,
		]);
		$teachers->accessRules()->attach(AccessRule::where('route', 'user.profile')->first());
		$teachers->accessRules()->attach(AccessRule::where('route', 'user.show')->first());
		$teachers->accessRules()->attach(AccessRule::where('route', 'groups.index')->first());
		$teachers->accessRules()->attach(AccessRule::where('route', 'groups.show')->first());

		$employees = Group::create([
			'name' => 'Employees',
			'description' => 'Administrators of the school',
			'deletable' => true,
			'editable' => true,
		]);
		$employees->accessRules()->attach(AccessRule::where('route', 'user.profile')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'user.show')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'groups.index')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'groups.show')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'groups.access-rules')->first());

		$students = Group::create([
			'name' => 'Students',
			'description' => 'Students of the school',
			'deletable' => false,
			'editable' => false,
		]);
		$students->accessRules()->attach(AccessRule::where('route', 'user.profile')->first());
    }
}
