<?php
/**
 * Created by PhpStorm.
 * User: steev
 * Date: 04/12/2016
 * Time: 07:17
 */

namespace App\Http\Controllers;


use App\Models\Processes\Step;
use Illuminate\Http\Request;

use App\Http\Requests;

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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'process_id' => 'exists:processes,id',
        ]);

        $step = new Process();
        $step->name = $request->get('name');
        $step->description = $request->get('description');
        if ($request->has('process_id'))
            $step->process_id = $request->get('process_id');
        $step->save();

        return ($step);
    }

    /**
     * Display the specified resource.
     *
     * To show all the details of the process' steps
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $step = Step::with('process')->findOrFail($id);

        return ($step);
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
        $step = Step::with('process')->findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'process' => 'exists:processes,id',
        ]);

        if ($request->has('name'))
            $step->name = $request->get('name');
        if ($request->has('description'))
            $step->description = $request->get('description');
        if ($request->has('process'))
            $step->process_id = $request->get('process');
        $step->save();

        return ($step);
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

		$step->delete();
    }
}