<?php

namespace App\Http\Controllers;

use App\Models\Pedagogy\Level;
use App\Models\Pedagogy\Subject;
use Illuminate\Http\Request;

use App\Models\Pedagogy\StudentClass;
use App\Models\Users\User;

class StudentClassController extends Controller
{
    /**
     * @api {get} /student-classes List student classes
	 * @apiName index
	 * @apiGroup Student Classes
	 *
     * @apiDescription Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->authorize('index', StudentClass::class);

	    $studentClasses = StudentClass::with('level')
		                              ->with('mainTeacher')
		                              ->get();

		return $studentClasses;
    }

    /**
     * @api {get} /student-classes/create Create student class form
	 * @apiName create
	 * @apiGroup Student Classes
	 *
     * @apiDescription Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->authorize('store', StudentClass::class);

	    $levels = Level::get();

		return [
			'levels' => $levels,
			'users' => User::get(),
			'subjects' => Subject::get(),
		];
    }

    /**
     * @api {post} /student-classes Store new student class
	 * @apiName store
	 * @apiGroup Student Classes
	 *
     * @apiDescription Store a newly created resource in storage.
	 *
	 * @apiParam {Number} level	The ID of the level for this student class
	 * @apiParam {String} name	Name of the student class
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('store', StudentClass::class);

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
     * @api {get} /student-classes/:id Display student class
	 * @apiName show
	 * @apiGroup Student Classes
	 *
     * @apiDescription Display the specified resource.
	 *
	 * @apiParam {Number} id	The ID of the student class
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentClass = StudentClass::with('level')
							        ->with('mainTeacher')
							        ->with('students')
							        ->with('subjects')
							        ->findOrFail($id);

	    $this->authorize('show', $studentClass);

	    return $studentClass;
    }

    /**
     * @api {get} /student-classes/:id/edit Edit student class form
	 * @apiName edit
	 * @apiGroup Student Classes
	 *
     * @apiDescription Show the form for editing the specified resource.
	 *
	 * @apiParam {Number} id	The ID of the student class
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $studentClass = StudentClass::findOrFail($id);

	    $this->authorize('update', $studentClass);

	    $levels = Level::get();

	    return [
		    'levels' => $levels,
		    'student_class' => $studentClass,
		    'users' => User::get(),
	    ];
    }

    /**
     * @api {put} /student-classes/:id Update student class
	 * @apiName update
	 * @apiGroup Student Classes
	 *
     * @apiDescription Update the specified resource in storage.
	 *
	 * @apiParam {Number} id	The ID of the student class
	 *
	 * @apiParam {Number} [level]	The ID of the level for this student class
	 * @apiParam {String} [name]	Name of the student class
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentClass = StudentClass::findOrFail($id);

	    $this->authorize('update', $studentClass);

	    $this->validate($request, [
			'level' => 'exists:levels,id',
            'name' => 'unique:student_classes,name,' . $id,
		]);

		if ($request->has('level'))
			$studentClass->level_id = $request->get('level');
		if ($request->has('name'))
			$studentClass->name = $request->get('name');
		$studentClass->save();

		return $studentClass;
    }

    /**
     * @api {delete} /student-classes/:id Delete student class
	 * @apiName destroy
	 * @apiGroup Student Classes
	 *
     * @apiDescription Remove the specified resource from storage.
	 *
	 * @apiParam {Number} id	The ID of the student class
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentClass = StudentClass::findOrFail($id);

	    $this->authorize('destroy', $studentClass);

	    $studentClass->delete();
    }

	/**
	 * @api {get} /student-classes/:id/students Display student class' students
	 * @apiName listStudents
	 * @apiGroup Student Classes
	 *
     * @apiDescription List all the students of the class
	 *
	 * @apiParam {Number} id	The ID of the student class
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
	 * @api {put} /student-classes/:id/students Update student class' students
	 * @apiName updateStudents
	 * @apiGroup Student Classes
	 *
     * @apiDescription Update the list of students that are in the class
	 *
	 * @apiParam {Number} id			The ID of the student class
	 *
	 * @apiParam {Number[]} students	The list of IDs of students to add to the class
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
	 * @api {get} /student-classes/:id/subjects Display student class' subjects
	 * @apiName listSubjects
	 * @apiGroup Student Classes
	 *
     * @apiDescription List all subjects taken by a class
	 *
	 * @apiParam {Number} id	The ID of the student class
	 *
	 * @param type $id
	 */
	public function listSubjects($id)
	{
		$studentClass = StudentClass::with('subjects')->findOrFail($id);

		return $studentClass->subjects;
	}

	/**
	 * @api {put} /student-classes/:id/subjects Update student class' subjects
	 * @apiName updateSubjects
	 * @apiGroup Student Classes
	 *
     * @apiDescription Update the list of subjects taken by a class
	 *
	 * @apiParam {Number} id			The ID of the student class
	 *
	 * @apiParam {Number[]} subjects	The list of IDs of subjects to add to the class
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
