<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\StudentClass;
use App\Models\Pedagogy\Level;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('index', Level::class);

        $levels = Level::get();

		return $levels;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->authorize('store', Level::class);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('store', Level::class);

	    $this->validate($request, [
			'name' => 'required|unique:levels,name',
		]);

		$level = new Level();
		$level->name = $request->get('name');
		$level->save();

		return $level;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$level = Level::with('studentClasses')->findOrFail($id);

	    $this->authorize('show', $level);

		return $level;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $level = Level::findOrFail($id);

	    $this->authorize('update', $level);

	    return $level;
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
		$level = Level::findOrFail($id);

	    $this->authorize('update', $level);

	    $this->validate($request, [
			'name' => 'unique:levels,name,' . $id,
		]);

		if ($request->has('name'))
			$level->name = $request->get('name');
		$level->save();

		return $level;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $level = Level::findOrFail($id);

	    $this->authorize('destroy', $level);

		$level->delete();
    }

	/**
	 * Add student classes to a level
	 *
	 * @param Request $request
	 * @param type $id
	 * @return type
	 */
	public function addStudentClasses(Request $request, $id)
	{
		$level = Level::with('studentClasses')->findOrFail($id);

		$this->authorize('addStudentClasses', $level);

		$this->validate($request, [
			'studentClasses.*' => 'exists:student_classes,id',
		]);

		$studentClasses = StudentClass::find($request->get('studentClasses'));
		foreach ($studentClasses as $studentClass)
		{
			$studentClass->level()->associate($level);
			$studentClass->save();
		}

		return Level::with('studentClasses')->find($id);
	}

	/**
	 * List all the student classes of a level
	 *
	 * @param type $id
	 * @return type
	 */
	public function listStudentClasses($id)
	{
		$level = Level::with('studentClasses')->findOrFail($id);

		$this->authorize('listStudentClasses', $level);

		return $level->studentClasses;
	}

	/**
	 * List all the subjects of a level
	 *
	 * @param type $id
	 * @return type
	 */
	public function listSubjects($id)
	{
		$level = Level::with('subjects')->findOrFail($id);

		$this->authorize('listSubjects', $level);

		return $level->subjects;
	}

}
