<?php
namespace App\Http\Controllers;

use App\Models\Processes\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * name, description and process are all stored.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('store', Step::class);

	    $this->validate($request, [
            'name' => 'required',
            'description' => '',
            'process_id' => 'exists:processes,id',
        ]);

        $step = new Process();
        $step->name = $request->get('name');
        $step->description = $request->get('description');
        if ($request->has('process_id'))
            $step->process_id = $request->get('process_id');
        $step->save();

        return $step;
    }

	public function edit($id)
	{
		$step = Step::findOrFail($id);

		$this->authorize('update', $step);

		return $step;
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
	    $step = Step::findOrFail($id);

	    $this->authorize('update', $step);

	    $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($request->has('name'))
            $step->name = $request->get('name');
        if ($request->has('description'))
            $step->description = $request->get('description');
        $step->save();

        return $step;
    }

    /**
     * Remove the specified resource (a process) from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $step = Step::findOrFail($id);

	    $this->authorize('destroy', $step);

	    $step->delete();
    }
}