<?php

namespace App\Http\Controllers;

use App\Models\Pedagogy\Level;
use App\Models\Users\User;
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
	    $this->authorize('index', Subject::class);

	    $subjects = Subject::with('teacher')
		                   ->with('level')
		                   ->get();

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
	    $this->authorize('store', Subject::class);

	    $users = User::get();
        $levels = Level::get();

        return [
        	'users' => $users,
	        'levels' => $levels,
        ];
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
	    $this->authorize('store', Subject::class);

	    $this->validate($request, [
			'level' => 'required|exists:levels,id',
			'name' => 'required',
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
        $subject = Subject::with('teacher')
	                      ->with('level')
	                      ->findOrFail($id);

	    $this->authorize('show', $subject);

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
	    $subject = Subject::findOrFail($id);

	    $this->authorize('update', $subject);

	    $users = User::get();
	    $levels = Level::get();

	    return [
		    'users' => $users,
		    'levels' => $levels,
		    'subject' => $subject,
	    ];
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

	    $this->authorize('update', $subject);

	    $this->validate($request, [
			'level' => 'exists:levels,id',
			'name' => '',
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

	    $this->authorize('destroy', $subject);

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
