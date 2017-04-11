<?php

use Illuminate\Database\Seeder;

use App\Models\Pedagogy\Level;
use App\Models\Pedagogy\StudentClass;

class StudentClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $studentClasses = [
			'Terminale S' => [
				'TS 1',
				'TS 2',
				'TS 3',
			],
			'Terminale ES' => [
				'TES 1',
				'TES 2',
				'TES 3',
			],
			'Terminale L' => [
				'TL 1',
				'TL 2',
			],
			'Première S' => [
				'1ere S 1',
				'1ere S 2',
				'1ere S 3',
			],
			'Première ES' => [
				'1ere ES 1',
				'1ere ES 2',
				'1ere ES 3',
			],
			'Première L' => [
				'1ere L 1',
				'1ere L 2',
			],
			'Seconde' => [
				'Seconde 1',
				'Seconde 2',
				'Seconde 3',
				'Seconde 4',
				'Seconde 5',
			],
		];

		foreach ($studentClasses as $level => $d)
		{
			$level = Level::where('name', $level)->first();

			foreach ($d as $studentClass)
			{
				$level->studentClasses()->save(new StudentClass(['name' => $studentClass]));
			}
		}
    }
}
