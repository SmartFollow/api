<?php

namespace App\Console\Commands\AI;

use App\Models\AI\ClassCriterionAverage;
use App\Models\Pedagogy\StudentClass;
use Illuminate\Console\Command;

class ClassCriteriaAverage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:criteria:class:average';

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
	    $prevMonday = date("Y-m-d", strtotime("last week monday"));
	    $prevSunday = date("Y-m-d 23:59:59", strtotime("last week sunday"));
	    $currentWeek = date("W");
	    $currentYear = date("Y");

	    $studentClasses = StudentClass::with('students.evaluations.criteria')
		    ->whereHas('students.evaluations', function ($q) use ($prevMonday, $prevSunday) {
			    $q->where('created_at', '>=', $prevMonday);
			    $q->where('created_at', '<=', $prevSunday);
		    })->get();

	    foreach ($studentClasses as $studentClass)
	    {
		    $criteriaAverage = [];

		    foreach ($studentClass->students as $student)
		    {
			    foreach ($student->evaluations as $evaluation)
			    {
				    if ($evaluation->created_at >= $prevMonday && $evaluation->created_at <= $prevSunday)
				    {
					    foreach ($evaluation->criteria as $criterion)
					    {
						    if ($criterion->stats_type == 'average')
							    $criteriaSum[$criterion->id]['values'][] = $criterion->pivot->value;
					    }
				    }
			    }
		    }

		    foreach ($criteriaAverage as $criterionId => &$criterion)
		    {
			    $criterion['average'] = array_sum($criterion['values']) / count($criterion['values']);;

			    $average = ClassCriterionAverage::updateOrCreate([
				    'student_class_id' => $studentClass->id,
				    'criterion_id' => $criterionId,
				    'week' => $currentWeek,
				    'year' => $currentYear,
			    ], [
				    'sum' => $criterion['sum'],
				    'week_start' => $prevMonday,
				    'week_end' => $prevSunday,
			    ]);
		    }

		    print_r($criteriaAverage);
	    }
    }
}
