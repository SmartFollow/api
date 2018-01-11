<?php

namespace App\Http\Controllers;

use App\Models\AI\Difficulty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DifficultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->authorize('index', Difficulty::class);

	    $currentWeek = date("W");
	    $currentYear = date("Y");

	    $difficulties = [];

	    if (Auth::user()->group->accessRules->keyBy('name')->has('difficulties.self.index'))
	    {
		    $difficulties['self_difficulties'] = Difficulty::with('student')
													       ->where('assigned_teacher_id', Auth::id())
			                                               ->where('week', $currentWeek)
			                                               ->where('year', $currentYear)
													       ->get();
	    }
	    if (Auth::user()->group->accessRules->keyBy('name')->has('difficulties.index'))
	    {
		    $difficulties['difficulties'] = Difficulty::with('student')
												       ->with('assignedTeacher')
												       ->where('week', $currentWeek)
												       ->where('year', $currentYear)
												       ->get();
	    }

	    return $difficulties;
    }
}
