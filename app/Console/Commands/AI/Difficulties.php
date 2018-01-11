<?php

namespace App\Console\Commands\AI;

use App\Models\AI\Difficulty;
use App\Models\AI\DifficultyHistory;
use App\Models\AI\StudentCriterionSum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Difficulties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:difficulties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the difficulties from the criteria';

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
	    $this->difficultyHistory();

	    /*
	     * Computing the difficulties
	     */
	    echo "\n=== Computing difficulties ===\n\n";

	    $currentWeek = date("W");
	    $currentYear = date("Y");
	    $lastMonthsWeek = date("W", strtotime("-3 week"));
	    $lastMonthsYear = date("Y", strtotime("-3 week"));

	    /*
	     * SELECT COUNT(*) AS count, student_id, u.class_id, sc.main_teacher_id
		 * FROM `difficulty_history` AS dh
		 * LEFT JOIN users AS u
		 *     ON u.id = dh.student_id
		 * LEFT JOIN student_classes AS sc
		 *     ON sc.id = u.class_id
		 * WHERE (week >= 50 AND year = 2017) OR (year > 2017)
		 * GROUP BY student_id
		 * HAVING count >= 3
	     */
		$studentsInDifficulty = DB::select('SELECT COUNT(*) AS count, student_id, u.class_id, sc.main_teacher_id FROM `difficulty_history` AS dh LEFT JOIN users AS u ON u.id = dh.student_id LEFT JOIN student_classes AS sc ON sc.id = u.class_id WHERE (week >= ? AND year = ?) OR (year > ?) GROUP BY student_id HAVING count >= 3',
											[$lastMonthsWeek, $lastMonthsYear, $lastMonthsYear]);

	    print_r($studentsInDifficulty);

	    echo "\n=== End computing difficulties ===\n";

	    echo "\n=== Storing difficulties ===\n\n";

	    foreach ($studentsInDifficulty as $student)
		{
			$difficulty = Difficulty::firstOrNew(['student_id' => $student->student_id, 'week' => $currentWeek, 'year' => $currentYear]);
			$difficulty->student_id = $student->student_id;
			$difficulty->assigned_teacher_id = $student->main_teacher_id;
			$difficulty->week = $currentWeek;
			$difficulty->year = $currentYear;
			$difficulty->save();

			print_r((object)($difficulty->toArray()));
		}
    }

    private function difficultyHistory()
    {
	    $lastWeek = date("W", strtotime("monday last week"));
	    $lastWeeksYear = date("Y", strtotime("monday last week"));
	    $currentWeek = date("W");
	    $currentYear = date("Y");

	    echo "Previous week: " . $lastWeek . " " . $lastWeeksYear . "\n";
	    echo "Current week: " . $currentWeek . " " . $currentYear . "\n";

	    /*
	     * Generating the difficulty score for the current week for each student
	     */
	    echo "\n=== Computing difficulty scores ===\n\n";

	    $studentsCriterionSums = StudentCriterionSum::where('week', $currentWeek)
		    ->where('year', $currentYear)
		    ->with('user')
		    ->with('criterion')
		    ->get();

	    $difficultyScores = [];
	    foreach ($studentsCriterionSums as $sum)
	    {
		    if (!isset($difficultyScores[$sum->user_id]))
		    {
			    $difficultyScores[$sum->user_id] = 0;
		    }

		    $previousStudentSum = StudentCriterionSum::where('week', $lastWeek)
			    ->where('year', $lastWeeksYear)
			    ->where('user_id', $sum->user_id)
			    ->where('criterion_id', $sum->criterion_id)
			    ->first();

		    if (!empty($previousStudentSum))
		    {
			    if (!empty($previousStudentSum) && $previousStudentSum->sum > 0 && abs($sum->sum / $previousStudentSum->sum * 100 - 100) >= $sum->criterion->difference_limit_percentage)
			    { // If the value difference matches for student value
				    switch ($this->getAlertType($sum->sum, $sum->sum / $previousStudentSum->sum * 100 - 100, $sum->criterion->impact, $sum->criterion->difference_limit_percentage))
				    {
					    case 'success':
						    $difficultyScores[$sum->user_id] -= 2;
						    break;
					    case 'info':
						    $difficultyScores[$sum->user_id] -= 1;
						    break;
					    case 'warning':
						    $difficultyScores[$sum->user_id] += 1;
						    break;
					    case 'danger':
						    $difficultyScores[$sum->user_id] += 2;
						    break;
					    default: break;
				    }
			    }
		    }
	    }
	    print_r($difficultyScores);

	    echo "\n=== End computing difficulty scores ===\n";

	    /*
	     * Storing the difficulty history
	     */
	    echo "\n=== Storing difficulty scores ===\n\n";
	    foreach ($difficultyScores as $userId => $difficultyScore)
	    {
		    if ($difficultyScore > 0)
		    {
			    $difficultyHistory = DifficultyHistory::firstOrNew(['student_id' => $userId, 'week' => $currentWeek, 'year' => $currentYear]);

			    $difficultyHistory->save();

			    print_r((object)($difficultyHistory->toArray()));
		    }
	    }
	    echo "\n=== End storing difficulty scores ===\n\n";
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
