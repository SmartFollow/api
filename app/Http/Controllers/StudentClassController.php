<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\StudentClass;
use App\Models\Users\User;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentClasses = StudentClass::get();

		return $studentClasses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'name' => 'required|unique:student_classes,name',
		]);

		$studentClass = new StudentClass();
		$studentClass->level_id = $request->get('level');
		$studentClass->name = $request->get('name');
		$studentClass->save();

		return $studentClass;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentClass = StudentClass::with('students')->findOrFail($id);

		return $studentClass;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $studentClass = StudentClass::findOrFail($id);

        $this->validate($request, [
			'level' => 'required|exists:levels,id',
            'name' => 'required|unique:student_classes,name,' . $id,
		]);

		if ($request->has('level'))
			$studentClass->level_id = $request->get('level');
		if ($request->has('name'))
			$studentClass->name = $request->get('name');
		$studentClass->save();

		return $studentClass;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentClass = StudentClass::findOrFail($id);

		$studentClass->delete();
    }

	/**
	 * List all the students of the class
	 *
	 * @param type $id
	 * @return type
	 */
	public function listStudents($id)
	{
		$studentClass = StudentClass::with('students')->findOrFail($id);

		return $studentClass->students;
	}

	/**
	 * Update the list of students that are in the class
	 *
	 * @param Request $request
	 * @param type $id
	 * @return type
	 */
	public function updateStudents(Request $request, $id)
	{
		$studentClass = StudentClass::with('students')->findOrFail($id);

		$this->validate($request, [
			'students.*' => 'exists:users,id',
		]);

		// Remove the students that are not in the class anymore
		foreach ($studentClass->students as $student)
		{
			if (!$request->has('students') || !in_array($student->id, $request->get('students')))
			{
				$student->studentClass()->dissociate();
				$student->save();
			}
		}

		// Add the new students
		$students = User::find($request->get('students'));
		foreach ($students as $student)
		{
			if ($student->studentClass() != $studentClass)
			{
				$student->studentClass()->associate($studentClass);
				$student->save();
			}
		}

		return StudentClass::with('students')->find($id);
	}

	/**
	 * List all subjects taken by a class
	 *
	 * @param type $id
	 */
	public function listSubjects($id)
	{
		$studentClass = StudentClass::with('subjects')->findOrFail($id);

		return $studentClass->subjects;
	}

	/**
	 * Update the list of subjects taken by a class
	 *
	 * @param Request $request
	 * @param type $id
	 * @return type
	 */
	public function updateSubjects(Request $request, $id)
	{
		$studentClass = StudentClass::with('subjects')->findOrFail($id);

		$this->validate($request, [
			'subjects.*' => 'exists:subjects,id',
		]);

		$studentClass->subjects()->sync($request->get('subjects'));

		return StudentClass::with('subjects')->find($id);
	}
}
