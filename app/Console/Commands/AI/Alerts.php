<?php

namespace App\Console\Commands\AI;

use App\Models\AI\ClassCriterionSum;
use App\Models\AI\StudentCriterionAverage;
use App\Models\AI\StudentCriterionSum;
use App\Models\Pedagogy\Alert;
use Illuminate\Console\Command;

class Alerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the alerts from the criteria';

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
	    $lastWeek = date("W", strtotime("monday last week"));
	    $lastWeeksYear = date("Y", strtotime("monday last week"));
	    $currentWeek = date("W");
	    $currentYear = date("Y");

	    $studentsCriterionSums = StudentCriterionSum::where('week', $currentWeek)
	                                                ->where('year', $currentYear)
	                                                ->with('user')
	                                                ->with('criterion')
	                                                ->get();

	    $classCriterionSums = [];
	    foreach ($studentsCriterionSums as $sum)
	    {
	    	if (!isset($classCriterionSums[$sum->user->class_id]))
	    	{ // If we never loaded sums for this class before
			    $classCriterionSums[$sum->user->class_id] = [];
		    }
	    	if (!isset($classCriterionSums[$sum->user->class_id][$sum->criterion_id]))
		    { // We didn't load the class sum for this criterion before
			    $classCriterionSums[$sum->user->class_id][$sum->criterion_id] = ClassCriterionSum::where('week', $currentWeek)
																							     ->where('year', $currentYear)
																							     ->where('student_class_id', $sum->user->class_id)
																							     ->where('criterion_id', $sum->criterion_id)
																							     ->with('studentClass.students')
																							     ->first();
		    }

			$previousStudentSum = StudentCriterionSum::where('week', $lastWeek)
													 ->where('year', $lastWeeksYear)
													 ->where('user_id', $sum->user_id)
													 ->where('criterion_id', $sum->criterion_id)
													 ->first();

	    	$classValue = null;
	    	if (!empty($classCriterionSums[$sum->user->class_id][$sum->criterion_id]))
			    $classValue = $classCriterionSums[$sum->user->class_id][$sum->criterion_id]->sum / count($classCriterionSums[$sum->user->class_id][$sum->criterion_id]->studentClass->students);

	    	if (!empty($classValue) || !empty($previousStudentSum))
		    {
			    $alert = Alert::firstOrNew(['criterion_id' => $sum->criterion_id, 'student_id' => $sum->user_id]);
			    $alert->student_value = $sum->sum;
			    $alert->week = $currentWeek;
			    $alert->year = $currentYear;

			    if (!empty($previousStudentSum) && $previousStudentSum->sum > 0 && abs($sum->sum / $previousStudentSum->sum * 100 - 100) >= $sum->criterion->difference_limit_percentage)
			    { // If the value difference matches for student value
				    $alert->class_value = null;
				    $alert->previous_student_value = $previousStudentSum->sum;
				    $alert->type = $this->getAlertType($sum->sum, $sum->sum / $previousStudentSum->sum * 100 - 100, $sum->criterion->impact, $sum->criterion->difference_limit_percentage);

				    $alert->save();

				    print_r($alert->toArray());
			    }
			    else if (!empty($classValue) && $classValue > 0 && abs($sum->sum / $classValue * 100 - 100) >= $sum->criterion->difference_limit_percentage)
			    { // If the value difference matches for class value and their is no student progression
				    $alert->previous_student_value = null;
				    $alert->class_value = $classValue;
					$alert->type = $this->getAlertType($sum->sum, $sum->sum / $classValue * 100 - 100, $sum->criterion->impact, $sum->criterion->difference_limit_percentage);

					$alert->save();

				    print_r($alert->toArray());
				}
		    }
	    }
    }

    private function getAlertType($studentValue, $difference, $impact, $difference_limit_percentage)
    {
	    $type = 'info';

	    if ($impact == 'neutral')
		    $type = 'info';
	    else if ($impact == 'positive' && $difference > 0)
		    $type = 'success'; // Positive criterion and positive value
	    else if ($impact == 'positive' && $difference < 0 && abs($difference) < $difference_limit_percentage * 2)
		    $type = 'warning'; // Positive criterion and low negative value
	    else if ($impact == 'positive' && $difference < 0 && abs($difference) >= $difference_limit_percentage * 2)
		    $type = 'danger'; // Positive criterion and high negative value

	    else if ($impact == 'negative' && $difference < 0 && $studentValue > 0)
		    $type = 'info'; // Negative criterion and negative value but still above 0
	    else if ($impact == 'negative' && $difference < 0)
		    $type = 'success'; // Negative criterion and negative value
	    else if ($impact == 'negative' && $difference > 0 && abs($difference) < $difference_limit_percentage * 2)
		    $type = 'warning'; // Negative criterion and low positive value
	    else if ($impact == 'negative' && $difference > 0 && abs($difference) >= $difference_limit_percentage * 2)
		    $type = 'danger'; // Negative criterion and high positive value

	    return $type;
    }
}
