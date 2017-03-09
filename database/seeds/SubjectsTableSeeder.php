<?php

use Illuminate\Database\Seeder;

use App\Models\Pedagogy\Level;
use App\Models\Pedagogy\StudentClass;
use App\Models\Pedagogy\Subject;
use App\Models\Users\User;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
			'Terminale S' => [
				'Mathématiques',
				'Physique',
				'Chimie',
				'SVT',
				'Anglais',
			],
			'Terminale ES' => [
				'Anglais',
				'Histoire / Géographie',
				'Français',
				'Sciences économiques et sociales',
				'Mathématiques',
			],
			'Terminale L' => [
				'Français',
				'Philosophie',
				'Histoire / Géographie',
				'Anglais',
			],
			'Première S' => [
				'Mathématiques',
				'Physique',
				'Chimie',
				'SVT',
				'Anglais',
				'Histoire / Géographie',
				'Français',
			],
			'Première ES' => [
				'Anglais',
				'Histoire / Géographie',
				'Français',
				'Sciences économiques et sociales',
				'Mathématiques',
			],
			'Première L' => [
				'Français',
				'Philosophie',
				'Histoire / Géographie',
				'Anglais',
			],
			'Seconde' => [
				'Mathématiques',
				'Physique',
				'Chimie',
				'SVT',
				'Anglais',
				'Histoire / Géographie',
				'Français',
				'Sciences économiques et sociales'
			],
		];

		$teachers = User::whereHas('group', function($q){
			$q->where('groups.name', 'Teachers');
		})->get();

		foreach ($subjects as $level => $d)
		{
			$level = Level::with('studentClasses')->where('name', $level)->first();

			foreach ($d as $subject)
			{
				$subjectObj = new Subject([
					'name' => $subject,
					'teacher_id' => count($teachers) > 0 ? $teachers[mt_rand(0, count($teachers) - 1)]->id : null,
				]);

				$level->subjects()->save($subjectObj);

				foreach ($level->studentClasses as $studentClass)
					$studentClass->subjects()->attach($subjectObj);
			}
		}
    }
}
