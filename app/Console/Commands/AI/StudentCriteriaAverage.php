<?php

namespace App\Console\Commands\AI;

use App\Models\Users\User;
use Illuminate\Console\Command;
use App\Models\AI\StudentCriterionAverage as StudentCriteriaAverageModel;

class StudentCriteriaAverage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:criteria:student:average';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    $prevMonday = date("Y-m-d", strtotime("monday this week"));
	    $prevSunday = date("Y-m-d 23:59:59", strtotime("sunday this week"));
	    $currentWeek = date("W");
	    $currentYear = date("Y");

	    $students = User::with('evaluations.criteria')
		                ->whereHas('evaluations', function ($q) use ($prevMonday, $prevSunday) {
				            $q->where('created_at', '>=', $prevMonday);
				            $q->where('created_at', '<=', $prevSunday);
				        })->get();

	    foreach ($students as $student)
	    {
	    	$criteriaAverage = [];

	    	foreach ($student->evaluations as $evaluation)
		    {
		    	if ($evaluation->created_at >= $prevMonday && $evaluation->created_at <= $prevSunday)
			    {
			    	foreach ($evaluation->criteria as $criterion)
				    {
				    	if ($criterion->stats_type == 'average')
					        $criteriaAverage[$criterion->id]['values'][] = $criterion->pivot->value;
				    }
			    }
		    }
		    foreach ($criteriaAverage as $criterionId => &$criterion)
		    {
			    $criterion['average'] = array_sum($criterion['values']) / count($criterion['values']);

			    $average = StudentCriteriaAverageModel::updateOrCreate([
			    	'user_id' => $student->id,
				    'criterion_id' => $criterionId,
				    'week' => $currentWeek,
				    'year' => $currentYear,
			    ], [
					'average' => $criterion['average'],
				    'week_start' => $prevMonday,
				    'week_end' => $prevSunday,
			    ]);
		    }

		    print_r($criteriaAverage);
	    }
    }
}
