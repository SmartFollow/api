<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$levels = [
			'Terminale S',
			'Terminale ES',
			'Terminale L',
			'Première S',
			'Première ES',
			'Première L',
			'Seconde',
		];

		foreach ($levels as $level)
		{
			DB::table('levels')->insert([
				'name' => $level,
			]);
		}
    }
}
