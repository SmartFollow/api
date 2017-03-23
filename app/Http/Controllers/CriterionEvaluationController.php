<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Pedagogy\Evaluations\Evaluation;
use App\Models\Pedagogy\Evaluations\Criterion;

class CriterionEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($evaluationId)
    {
        $evaluation = Evaluation::with('criteria')
								->findOrFail($evaluationId);

		return $evaluation->criteria;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($evaluationId)
    {
        $availableCriteria = Criterion::get();
		$evaluation = Evaluation::with('criteria')->findOrFail($evaluationId);

		return [
			'available_criteria' => $availableCriteria,
			'evaluated_criteria' => $evaluation->criteria,
		];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $evaluationId)
    {
		$this->validate($request, [
			'criterion_id' => 'required|exists:criteria,id',
			'value' => 'required|json',
		]);

        $evaluation = Evaluation::with('criteria')->findOrFail($evaluationId);

		// Check if user doesn't have this evaluation yet
		if ($evaluation->criteria->contains($request->get('criterion_id')))
			abort(400, trans('criterion_evaluation.criterion_evaluation_already_exists'));

		$evaluation->criteria()->attach($request->get('criterion_id'), ['value' => $request->get('value')]);

		$evaluation->load('criteria');

		return $evaluation->criteria;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($evaluationId, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($evaluationId, $id)
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
    public function update(Request $request, $evaluationId, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($evaluationId, $id)
    {
        //
    }
}
