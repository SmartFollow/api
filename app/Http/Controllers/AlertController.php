<?php

namespace App\Http\Controllers;

use App\Models\Pedagogy\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('index', Alert::class);

	    $currentWeek = date("W");
	    $currentYear = date("Y");

        $alerts = Alert::with('criterion')
	                   ->where('student_id', Auth::id())
	                   ->where('week', $currentWeek)
	                   ->where('year', $currentYear)
                       ->get();

        return $alerts;
    }
}
