<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Subject;

class SubjectController extends Controller
{
    /**
     * @api {get} /subjects List subjects
	 * @apiName index
	 * @apiGroup Subjects
	 *
     * @apiDescription Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::get();

		return $subjects;
    }

    /**
     * @api {get} /subjects/create Create subject form
	 * @apiName create
	 * @apiGroup Subjects
	 *
     * @apiDescription Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @api {post} /subjects Store new subject
	 * @apiName store
	 * @apiGroup Subjects
	 *
     * @apiDescription Store a newly created resource in storage.
	 *
	 * @apiParam {Number} level			The ID of the level of the subject
	 * @apiParam {String} name			Name
	 * @apiParam {String} [description]	Description
	 * @apiParam {Number} teacher		The ID of the user that will be the teacher of the subject
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
     * @api {get} /subjects/:id Display subject
	 * @apiName show
	 * @apiGroup Subjects
	 *
     * @apiDescription Display the specified resource.
	 *
	 * @apiParam {Number} id	The ID of the subject to display
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
     * @api {get} /subjects/:id/edit Edit subject form
	 * @apiName edit
	 * @apiGroup Subjects
	 *
     * @apiDescription Show the form for editing the specified resource.
	 *
	 * @apiParam {Number} id	The ID of the subject to edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
	 * @api {get} /subjects/:id/edit Edit subject form
	 * @apiName update
	 * @apiGroup Subjects
	 *
     * @apiDescription Update the specified resource in storage.
	 *
	 * @apiParam {Number} id	The ID of the subject to display
	 *
	 * @apiParam {Number} [level]		The ID of the level of the subject
	 * @apiParam {String} [name]		Name
	 * @apiParam {String} [description]	Description
	 * @apiParam {Number} [teacher]		The ID of the user that will be the teacher of the subject
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
     * @api {delete} /subjects/:id Delete subject
	 * @apiName destroy
	 * @apiGroup Subjects
	 *
     * @apiDescription Remove the specified resource from storage.
	 *
	 * @apiParam {Number} id	The ID of the subject to delete
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
	 * @api {get} /subjects/:id/student-classes List subject's student classes
	 * @apiName listStudentClasses
	 * @apiGroup Subjects
	 *
     * @apiDescription List all the student classes of a subject
	 *
	 * @apiParam {Number} id	The ID of the subject
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
