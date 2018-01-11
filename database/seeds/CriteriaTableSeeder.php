<?php

use Illuminate\Database\Seeder;

use App\Models\Pedagogy\Evaluations\Criterion;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $participation = Criterion::create([
			'name' => 'Participation',
			'impact' => 'positive',
			'difference_limit_percentage' => 25,
			'check_interval' => 3600 * 24,
			'stats_type' => 'sum',
		]);
		
		$missingHomeworks = Criterion::create([
			'name' => 'Devoirs non réalisés',
			'impact' => 'negative',
			'difference_limit_percentage' => 0,
			'check_interval' => 3600 * 24 * 7,
			'stats_type' => 'sum',
		]);
		
		$chatInClass = Criterion::create([
			'name' => 'Bavardage en classe',
			'impact' => 'negative',
			'difference_limit_percentage' => 10,
			'check_interval' => 3600 * 24 * 7,
			'stats_type' => 'sum',
		]);
    }
}
