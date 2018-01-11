<?php
namespace App\Http\Controllers;

use App\Models\Processes\Process;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProcessController extends Controller
{
    /**
     * Getter
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->authorize('index', Process::class);

        return Process::with('steps')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * name and description are both stored.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('store', Process::class);

	    $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $process = new Process();
        $process->name = $request->get('name');
        $process->description = $request->get('description');
        $process->save();

        return ($process);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $process = Process::with('steps')->findOrFail($id);

	    $this->authorize('show', $process);

	    return $process;
    }

	public function edit($id)
	{
		$process = Process::findOrFail($id);

		$this->authorize('update', $process);

		return $process;
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
        $process = Process::findOrFail($id);

	    $this->authorize('update', $process);

	    $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($request->has('name'))
            $process->name = $request->get('name');
        if ($request->has('description'))
            $process->description = $request->get('description');
        $process->save();

        return ($process);
    }

    /**
     * Remove the specified resource (a process) from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $process = Process::findOrFail($id);

	    $this->authorize('destroy', $process);

	    $process->delete();
    }
}
