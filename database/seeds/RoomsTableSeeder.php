<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    foreach (['A', 'B', 'C', 'D'] as $building)
	    {
	    	for ($i = 1; $i < 4; $i++)
		    {
		    	$max = mt_rand(2, 9);
		    	for ($j = 0; $j < $max; $j++)
			    {
				    DB::table('rooms')->insert([
					    'identifier' => $building . $i . '0' . $j,
					    'seats' => rand(30, 44),
				    ]);
			    }
		    }
	    }
    }
}
