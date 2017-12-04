<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\AI\ClassCriteriaSum::class,
        Commands\AI\ClassCriteriaAverage::class,
        Commands\AI\ClassAbsenceDelaySum::class,
        Commands\AI\StudentCriteriaAverage::class,
        Commands\AI\StudentCriteriaSum::class,
	    Commands\AI\StudentAbsenceDelaySum::class,
	    Commands\AI\GivenCriteriaAverage::class,
	    Commands\AI\GivenCriteriaSum::class,
	    Commands\AI\GivenAbsenceDelaySum::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
