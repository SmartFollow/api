<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::get();

		return $subjects;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
			'level' => 'required|exists:levels,id',
			'name' => 'required|unique:subjects,name',
			'description' => '',
			'teacher' => 'required|exists:users,id',
		]);

		$subject = new Subject();
		$subject->level_id = $request->get('level');
		$subject->name = $request->get('name');
		$subject->description = $request->get('description');
		$subject->teacher_id = $request->get('teacher');
		$subject->save();

		return $subject;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = Subject::findOrFail($id);

		return $subject;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
		$subject = Subject::findOrFail($id);

        $this->validate($request, [
			'level' => 'exists:levels,id',
			'name' => 'unique:subjects,name',
			'description' => '',
			'teacher' => 'exists:users,id',
		]);

		if ($request->has('level'))
			$subject->level_id = $request->get('level');
		if ($request->has('name'))
			$subject->name = $request->get('name');
		if ($request->has('description'))
			$subject->description = $request->get('description');
		if ($request->has('teacher'))
			$subject->teacher_id = $request->get('teacher');
		$subject->save();

		return $subject;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);

		$subject->delete();
    }

	/**
	 * List all the student classes of a subject
	 *
	 * @param type $id
	 * @return type
	 */
	public function listStudentClasses($id)
	{
		$subject = Subject::with('studentClasses')->findOrFail($id);

		return $subject->studentClasses;
	}
}
