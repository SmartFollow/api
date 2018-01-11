<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class AIController extends Controller
{
    public function criteriaStudentsSum()
    {
	    Artisan::call('ai:criteria:student:sum');
    }

    public function criteriaStudentsAverage()
    {
	    Artisan::call('ai:criteria:student:average');
    }

    public function absenceDelaysStudents()
    {
	    Artisan::call('ai:absdelay:student');
    }

	public function criteriaClassesSum()
	{
		Artisan::call('ai:criteria:class:sum');
	}

	public function criteriaClassesAverage()
	{
		Artisan::call('ai:criteria:class:average');
	}

	public function absenceDelaysClasses()
	{
		Artisan::call('ai:absdelay:class');
	}

	public function criteriaGivenSum()
	{
		Artisan::call('ai:criteria:given:sum');
	}

	public function criteriaGivenAverage()
	{
		Artisan::call('ai:criteria:given:average');
	}

	public function absenceDelaysGiven()
	{
		Artisan::call('ai:absdelay:given');
	}

	public function alerts()
	{
		Artisan::call('ai:alerts');
	}

	public function difficulties()
	{
		Artisan::call('ai:difficulties');
	}
}
