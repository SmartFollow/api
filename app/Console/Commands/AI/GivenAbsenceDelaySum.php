<?php

namespace App\Console\Commands\AI;

use App\Models\AI\GivenAbsencesDelaysSum;
use App\Models\Pedagogy\Evaluations\Evaluation;
use Illuminate\Console\Command;

class GivenAbsenceDelaySum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:absdelay:given';

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

		    	if (!empty($teacherId))
			    {
				    if (!empty($evaluation->absence))
					    $d[$teacherId]['absences'] = empty($d[$teacherId]['absences']) ? 1 : $d[$teacherId]['absences']++;
				    if (!empty($evaluation->delay))
					    $d[$teacherId]['delays'] = empty($d[$teacherId]['delays']) ? 1 : $d[$teacherId]['delays']++;
			    }
		    }
	    }
	    unset($evaluation);

	    print_r($d);

	    foreach ($d as $teacherId => $evaluation)
	    {
		    GivenAbsencesDelaysSum::updateOrCreate([
			    'teacher_id' => $teacherId,
			    'week' => $currentWeek,
			    'year' => $currentYear,
		    ], [
			    'absences' => $evaluation['absences'] ?? 0,
			    'delays' => $evaluation['delays'] ?? 0,
			    'week_start' => $prevMonday,
			    'week_end' => $prevSunday,
		    ]);
	    }
    }
}
