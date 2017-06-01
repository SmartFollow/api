<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Evaluations\Absence;
use App\Models\Pedagogy\Evaluations\Delay;

class DelayController extends Controller
{

    /**
     * @api {post} /evaluations/:evaluationId/delays Store new delay
	 * @apiName store
	 * @apiGroup Delays
	 *
     * @apiDescription Store a newly created delay in storage.
	 * If an existing absence exists, it is automatically destroyed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $evaluationId)
    {
		$this->validate($request, [
			'arrived_at' => 'date_format:H:i',
		]);

		$absence = Absence::where('evaluation_id', $evaluationId)->first();
		if (!empty($absence))
			$absence->delete();

        $delay = new Delay();
		$delay->evaluation_id = $evaluationId;
		$delay->arrived_at = $request->get('arrived_at');
		$delay->save();

		return $delay;
    }

    /**
     * @api {delete} /evaluations/:evaluationId/delays/:delayId Delete delay
	 * @apiName destroy
	 * @apiGroup Delays
	 *
     * @apiDescription Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($evaluationId, $id)
    {
        $delay = Delay::findOrFail($id);
		$delay->delete();
    }
}
