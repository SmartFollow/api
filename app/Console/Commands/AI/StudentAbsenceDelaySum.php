<?php

namespace App\Console\Commands\AI;

use App\Models\AI\StudentAbsencesDelaysSum;
use App\Models\Users\User;
use Illuminate\Console\Command;

class StudentAbsenceDelaySum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:absdelay:student';

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

	    $students = User::with('evaluations.absence')
		    ->with('evaluations.delay')
		    ->whereHas('evaluations', function ($q) use ($prevMonday, $prevSunday) {
			    $q->where('created_at', '>=', $prevMonday);
			    $q->where('created_at', '<=', $prevSunday);
		    })->get();

	    foreach ($students as $student)
	    {
	    	$absences = 0;
	    	$delays = 0;

		    foreach ($student->evaluations as $evaluation)
		    {
			    if ($evaluation->created_at >= $prevMonday && $evaluation->created_at <= $prevSunday)
			    {
				    if (!empty($evaluation->absence))
				    	$absences++;
				    if (!empty($evaluation->delay))
				    	$delays++;
			    }
		    }

		    StudentAbsencesDelaysSum::updateOrCreate([
			    'user_id' => $student->id,
			    'week' => $currentWeek,
			    'year' => $currentYear,
		    ], [
			    'absences' => $absences,
			    'delays' => $delays,
			    'week_start' => $prevMonday,
			    'week_end' => $prevSunday,
		    ]);
	    }
    }
}
