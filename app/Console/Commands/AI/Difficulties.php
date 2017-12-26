<?php

namespace App\Console\Commands\AI;

use Illuminate\Console\Command;

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
        //
    }
}
