<?php

namespace App\Console\Commands\AI;

use App\Models\AI\ClassAbsencesDelaysSum;
use App\Models\Pedagogy\StudentClass;
use Illuminate\Console\Command;

class ClassAbsenceDelaySum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:absdelay:class';

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

	    $studentClasses = StudentClass::with('students.evaluations.absence')
								      ->with('students.evaluations.delay')
								      ->whereHas('students.evaluations', function ($q) use ($prevMonday, $prevSunday) {
									      $q->where('created_at', '>=', $prevMonday);
									      $q->where('created_at', '<=', $prevSunday);
								      })->get();

	    foreach ($studentClasses as $studentClass)
	    {
		    $absences = 0;
		    $delays = 0;

		    foreach ($studentClass->students as $student)
		    {
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
		    }

		    ClassAbsencesDelaysSum::updateOrCreate([
			    'student_class_id' => $studentClass->id,
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
