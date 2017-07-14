<?php

namespace App\Http\Controllers;

use App\Models\AI\StudentCriterionAverage;
use App\Models\AI\StudentCriterionSum;
use App\Models\Pedagogy\Graph;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $graphs = Graph::with('criterion')->get();

        foreach ($graphs as &$graph)
        {
        	$range = new \DateTime();
        	$range->modify('- ' . $graph->days_range . ' days');

        	if ($graph->type == 'bar')
	        {
	        	$values = StudentCriterionSum::where('user_id', Auth::id())
			                                 ->where('criterion_id', $graph->criterion_id)
			                                 ->where('week_start', '>=', $range)
									         ->orderBy('year', 'ASC')
									         ->orderBy('week', 'ASC')
			                                 ->get();

	        	$graph->values = $values;
	        }
	        else
	        {
		        $values = StudentCriterionAverage::where('user_id', Auth::id())
			                                     ->where('criterion_id', $graph->criterion_id)
										         ->where('week_start', '>=', $range)
										         ->orderBy('year', 'ASC')
										         ->orderBy('week', 'ASC')
										         ->get();

		        $graph->values = $values;
	        }
        }

        return $graphs;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
