<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Evaluations\Absence;
use App\Models\Pedagogy\Evaluations\Delay;

class AbsenceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $evaluationId)
    {
		$delay = Delay::where('evaluation_id', $evaluationId)->first();
		if (!empty($delay))
			$delay->delete();
		
        $absence = new Absence();
		$absence->evaluation_id = $evaluationId;
		$absence->save();
		
		return $absence;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($evaluationId, $id)
    {
        $absence = Absence::findOrFail($id);
		$absence->delete();
    }
}
