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
			'name' => 'Administrateurs',
			'description' => 'Administrateurs du logiciel',
			'deletable' => false,
			'editable' => false,
		]);
		$administrators->accessRules()->attach(AccessRule::where('route', 'users.index')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'users.show')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'users.profile')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'users.create')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'users.update')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'users.destroy')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.index')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.create')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.store')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.show')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.edit')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.update')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.destroy')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'groups.show.access-rules')->first());
		$administrators->accessRules()->attach(AccessRule::where('route', 'lessons.index')->first());

		$teachers = Group::create([
			'name' => 'Professeurs',
			'description' => 'Professeurs de l\'école',
			'deletable' => false,
			'editable' => false,
		]);
        $teachers->accessRules()->attach(AccessRule::where('route', 'users.index')->first());
		$teachers->accessRules()->attach(AccessRule::where('route', 'users.profile')->first());
		$teachers->accessRules()->attach(AccessRule::where('route', 'users.show')->first());
		$teachers->accessRules()->attach(AccessRule::where('route', 'groups.index')->first());
		$teachers->accessRules()->attach(AccessRule::where('route', 'groups.show')->first());
		$teachers->accessRules()->attach(AccessRule::where('route', 'lessons.self.index')->first());

		$employees = Group::create([
			'name' => 'Employés',
			'description' => 'Employés de l\'école',
			'deletable' => true,
			'editable' => true,
		]);
		$employees->accessRules()->attach(AccessRule::where('route', 'users.index')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'users.show')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'users.profile')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'users.create')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'users.update')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'users.destroy')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'groups.index')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'groups.show')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'groups.show.access-rules')->first());
		$employees->accessRules()->attach(AccessRule::where('route', 'lessons.index')->first());

		$students = Group::create([
			'name' => 'Étudiants',
			'description' => 'Étudiants de l\'école',
			'deletable' => false,
			'editable' => false,
		]);
        $students->accessRules()->attach(AccessRule::where('route', 'users.index')->first());
        $students->accessRules()->attach(AccessRule::where('route', 'users.profile')->first());
        $students->accessRules()->attach(AccessRule::where('route', 'lessons.self.index')->first());
    }
}
