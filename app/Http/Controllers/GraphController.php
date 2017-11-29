<?php

namespace App\Http\Controllers;

use App\Models\AI\GivenCriterionSum;
use App\Models\AI\StudentCriterionAverage;
use App\Models\AI\StudentCriterionSum;
use App\Models\Pedagogy\Evaluations\Criterion;
use App\Models\Pedagogy\Graph;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $graphs = Graph::with('criterion');
        if (!Auth::user()->group->accessRules->keyBy('name')->has('criteria.summary.given'))
	        $graphs = $graphs->where('summary_type', '!=','given');
	    if (!Auth::user()->group->accessRules->keyBy('name')->has('criteria.summary.received'))
	        $graphs = $graphs->where('summary_type', '!=','received');
	    $graphs = $graphs->get();

        foreach ($graphs as &$graph)
        {
        	$range = new \DateTime();
        	$range->modify('- ' . $graph->days_range . ' days');

	        if ($graph->type == 'bar')
	        {
		        $values = $graph->summary_type == 'received' ?
			        StudentCriterionSum::where('user_id', Auth::id()) :
			        GivenCriterionSum::where('teacher_id', Auth::id());

		        $values = $values->where('criterion_id', $graph->criterion_id)
			        ->where('week_start', '>=', $range)
			        ->orderBy('year', 'ASC')
			        ->orderBy('week', 'ASC')
			        ->get();

		        $graph->values = $values;
	        }
	        else
	        {
		        $values = $graph->summary_type == 'received' ?
			        StudentCriterionAverage::where('user_id', Auth::id()) :
			        GivenCriterionAverage::where('teacher_id', Auth::id());

		        $values = $values->where('criterion_id', $graph->criterion_id)
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
    	$criteria = Criterion::get();

        return [
        	'criteria' => $criteria,
	        'types' => ['bar' => trans('graphs.bar'), 'line' => trans('graphs.line')],
	        'summary_types' => ['given' => trans('graphs.summary_given'), 'received' => trans('graphs.summary_received')],
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        	'criterion_id' => 'required|exists:criteria,id',
	        'type' => ['required', Rule::in(['bar', 'line'])],
	        'days_range' => 'required|integer|min:1',
	        'summary_type' => ['required', Rule::in(['given', 'received'])],
        ]);

        $graph = new Graph();
        $graph->criterion_id = $request->criterion_id;
        $graph->type = $request->type;
        $graph->days_range = $request->days_range;
        $graph->summary_type = $request->summary_type;
        $graph->save();

        return $graph;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    $graph = Graph::with('criterion')->findOrFail($id);

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

	    return $graph;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $graph = Graph::findOrFail($id);

	    $criteria = Criterion::get();

	    return [
	    	'graph' => $graph,
		    'criteria' => $criteria,
		    'types' => [ 'bar' => trans('graphs.bar'), 'line' => trans('graphs.line') ],
	        'summary_types' => ['given' => trans('graphs.summary_given'), 'received' => trans('graphs.summary_received')],
	    ];
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
	    $this->validate($request, [
		    'criterion_id' => 'exists:criteria,id',
		    'type' => [Rule::in(['bar', 'line'])],
		    'days_range' => 'integer|min:1',
	    ]);

	    $graph = Graph::findOrFail($id);
	    if ($request->has('criterion_id'))
		    $graph->criterion_id = $request->criterion_id;
	    if ($request->has('type'))
		    $graph->type = $request->type;
	    if ($request->has('days_range'))
		    $graph->days_range = $request->days_range;
	    if ($request->has('summary_type'))
		    $graph->summary_type = $request->summary_type;
	    $graph->save();

	    return $graph;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $graph = Graph::findOrFail($id);

        $graph->delete();
    }
}
