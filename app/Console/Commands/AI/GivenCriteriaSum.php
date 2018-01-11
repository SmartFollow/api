<?php

namespace App\Console\Commands\AI;

use App\Models\AI\GivenCriterionSum;
use App\Models\Pedagogy\Evaluations\Evaluation;
use App\Models\Users\User;
use Illuminate\Console\Command;
use App\Models\AI\StudentCriterionAverage as StudentCriteriaAverageModel;

class GivenCriteriaSum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:criteria:given:sum';

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

	    $evaluations = Evaluation::with('absence')
		    ->with('delay')
		    ->with('lesson.subject')
		    ->where('created_at', '>=', $prevMonday)
		    ->where('created_at', '<=', $prevSunday)
		    ->get();

	    $d = [];
	    foreach ($evaluations as $evaluation)
	    {
		    if ($evaluation->created_at >= $prevMonday && $evaluation->created_at <= $prevSunday)
		    {
			    $teacherId = $evaluation->lesson->subject->teacher_id;

			    foreach ($evaluation->criteria as $criterion)
			    {
				    if (!empty($teacherId))
				    {
					    if ($criterion->stats_type == 'sum')
						    $d[$teacherId][$criterion->id]['values'][] = $criterion->pivot->value;
				    }
			    }
		    }
	    }
	    unset($evaluation);

	    foreach ($d as $teacherId => &$criteria)
	    {
		    foreach ($criteria as $criterionId => &$criterion)
		    {
			    $criterion['sum'] = array_sum($criterion['values']);

			    GivenCriterionSum::updateOrCreate([
				    'teacher_id' => $teacherId,
				    'criterion_id' => $criterionId,
				    'week' => $currentWeek,
				    'year' => $currentYear,
			    ], [
				    'sum' => $criterion['sum'],
				    'week_start' => $prevMonday,
				    'week_end' => $prevSunday,
			    ]);
		    }
	    }

	    print_r($d);
    }
}
