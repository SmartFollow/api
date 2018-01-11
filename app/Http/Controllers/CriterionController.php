<?php

namespace App\Http\Controllers;

use App\Models\Pedagogy\Evaluations\Criterion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CriterionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->authorize('index', Criterion::class);

	    $criteria = Criterion::get();

	    return $criteria;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->authorize('store', Criterion::class);

	       return [
        	'impacts' => [
        		'neutral' => trans('criteria.neutral'),
		        'positive' => trans('criteria.positive'),
		        'negative' => trans('criteria.negative')
	        ],
	        'stats_types' => [
	        	'sum' => trans('criteria.sum'),
		        // 'average' => trans('criteria.average')
	        ]
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
	    $this->authorize('store', Criterion::class);

	    $this->validate($request, [
		    'name' => 'required',
		    'impact' => ['required', Rule::in(['negative', 'neutral', 'positive'])],
		    'difference_limit_percentage' => 'required|integer|min:0|max:100',
		    'check_interval' => 'required|integer|min:0',
		    'stats_type' => ['required', Rule::in(['sum'])]
	    ]);

	    $criterion = new Criterion();
	    $criterion->name = $request->name;
	    $criterion->impact = $request->impact;
	    $criterion->difference_limit_percentage = $request->difference_limit_percentage;
	    $criterion->check_interval = $request->check_interval;
	    $criterion->stats_type = $request->stats_type;
	    $criterion->save();

	    return $criterion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $criterion = Criterion::findOrFail($id);

	    $this->authorize('show', $criterion);

        return $criterion;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $criterion = Criterion::findOrFail($id);

	    $this->authorize('update', $criterion);

	    return [
	    	'criterion' => $criterion,
		    'impacts' => [
			    'neutral' => trans('criteria.neutral'),
			    'positive' => trans('criteria.positive'),
			    'negative' => trans('criteria.negative')
		    ],
		    'stats_types' => [
			    'sum' => trans('criteria.sum'),
			    // 'average' => trans('criteria.average')
		    ]
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
	    $criterion = Criterion::findOrFail($id);

	    $this->authorize('update', $criterion);

	    $this->validate($request, [
		    'name' => '',
		    'impact' => [Rule::in(['negative', 'neutral', 'positive'])],
		    'difference_limit_percentage' => 'integer|min:0|max:100',
		    'check_interval' => 'integer|min:0',
		    'stats_type' => [Rule::in(['sum'])]
	    ]);

	    if ($request->has('name'))
	        $criterion->name = $request->name;
	    if ($request->has('impact'))
		    $criterion->impact = $request->impact;
	    if ($request->has('difference_limit_percentage'))
		    $criterion->difference_limit_percentage = $request->difference_limit_percentage;
	    if ($request->has('check_interval'))
		    $criterion->check_interval = $request->check_interval;
	    if ($request->has('stats_type'))
		    $criterion->stats_type = $request->stats_type;
	    $criterion->save();

	    return $criterion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $criterion = Criterion::findOrFail($id);

	    $this->authorize('destroy', $criterion);

	    $criterion->delete();
    }
}
