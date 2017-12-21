<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Evaluations\Absence;
use App\Models\Pedagogy\Evaluations\Delay;

class AbsenceController extends Controller
{

	public function index(Request $request)
	{
		$this->authorize('index', Absence::class);

		$absences = Absence::with('evaluation.student')
						   ->with('evaluation.lesson.subject.teacher');
		if ($request->get('type') == 'unjustified')
			$absences = $absences->where('justified_at', null);
		$absences = $absences->get();

		return $absences;
	}

    /**
     * @api {post} /evaluations/:evaluationId/absences Store new absence
	 * @apiName store
	 * @apiGroup Absences
	 *
     * @apiDescription Store a newly created absence in storage.
	 * If an existing delay exists, it is automatically destroyed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $evaluationId)
    {
	    $this->authorize('store', Absence::class);

		$delay = Delay::where('evaluation_id', $evaluationId)->first();
		if (!empty($delay))
			$delay->delete();

        $absence = new Absence();
		$absence->evaluation_id = $evaluationId;
		$absence->save();

		return $absence;
    }

	/**
     * @api {get} /evaluations/:evaluationId/absences/:absenceId/edit Display edition form
	 * @apiName edit
	 * @apiGroup Absences
	 *
     * @apiDescription Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $absence = Absence::findOrFail($id);

	    $this->authorize('update', $absence);

		return $absence;
    }

	/**
     * @api {put} /evaluations/:evaluationId/absences/:absenceId Update absence
	 * @apiName update
	 * @apiGroup Absences
	 *
     * @apiDescription Update the specified resource in storage.
	 *
	 * @apiParam {String}	[justified_at]	The moment when the absence was justified
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$this->validate($request, [
			'justified_at' => 'required|date'
		]);

		$absence = Absence::findOrFail($id);

	    $this->authorize('update', $absence);

	    $absence->justified_at = new \DateTime($request->get('justified_at'));
		$absence->save();

	    $absence->load('evaluation');
	    $absence->evaluation->load('student');
	    $absence->evaluation->load('lesson.subject.teacher');

		return $absence;
    }

    /**
     * @api {delete} /evaluations/:evaluationId/absences/:absenceId Delete absence
	 * @apiName destroy
	 * @apiGroup Absences
	 *
     * @apiDescription Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($evaluationId, $id)
    {
        $absence = Absence::findOrFail($id);

	    $this->authorize('destroy', $absence);

	    $absence->delete();
    }
}
