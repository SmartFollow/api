<?php

namespace App\Http\Controllers;

use App\Models\Pedagogy\Lesson;
use App\Models\Pedagogy\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Users\User;
use App\Models\Users\Group;

class UserController extends Controller
{
    /**
	 * @api {get} /users List users
	 * @apiName index
	 * @apiGroup Users
	 *
     * @apiDescription Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->authorize('index', User::class);

		return User::with('studentClass')
				   ->with('group')
				   ->get();
    }

	/**
     * @api {get} /profile/access-rules User access rules
	 * @apiName profileAccessRules
	 * @apiGroup Users
	 *
     * @apiDescription Display the access rules of the authenticated user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function profileAccessRules()
	{
		$group = Group::with('accessRules')->findOrFail(Auth::user()->group_id);

		return $group->accessRules->pluck('route');
	}

	public function create()
	{
		$this->authorize('create', User::class);

		$groups = Group::get();

		$studentClasses = StudentClass::get();

		return [
			'groups' => $groups,
			'student_classes' => $studentClasses
		];
	}

    /**
     * @api {post} /users Store new user
	 * @apiName store
	 * @apiGroup Users
	 *
     * @apiDescription Store a newly created resource in storage.
	 *
	 * @apiParam {String} firstname			Firstname
	 * @apiParam {String} lastname			Lastname
	 * @apiParam {String} email				Email address
	 * @apiParam {String} password			Password
	 * @apiParam {Number} [group]			ID of the group
	 * @apiParam {Number} [studentClass]	ID of the student class
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->authorize('create', User::class);

    	$this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
			'group' => 'exists:groups,id',
			'student_class' => 'exists:student_classes,id',
		]);

		$user = new User();
        $user->firstname = $request->get('firstname');
        $user->lastname = $request->get('lastname');
		$user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
		if ($request->has('group'))
			$user->group_id = $request->get('group');
		if ($request->has('student_class'))
			$user->class_id = $request->get('student_class');
		$user->save();

		return ($user);
    }

    public function edit($id)
    {
    	$user = User::findOrFail($id);

    	$this->authorize('update', $user);

    	$groups = Group::get();

    	$studentClasses = StudentClass::get();

    	return [
    		'user' => $user,
		    'groups' => $groups,
		    'student_classes' => $studentClasses
	    ];
    }

    /**
     * @api {put} /users/:id Update user
	 * @apiName update
	 * @apiGroup Users
	 *
     * @apiDescription Update the specified resource in storage.
	 *
	 * @apiParam {Number} id				The ID of the user to update
	 *
	 * @apiParam {String} [firstname]		Firstname
	 * @apiParam {String} [lastname]		Lastname
	 * @apiParam {String} [email]			Email address
	 * @apiParam {String} [password]		Password
	 * @apiParam {Number} [group]			ID of the group
	 * @apiParam {Number} [studentClass]	ID of the student class
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

		$this->authorize('update', $user);

		$this->validate($request, [
            'firstname' => '',
            'lastname' => '',
            'email' => 'email|unique:users,email,' . $id,
            'password' => '',
			'group' => 'exists:groups,id',
			'student_class' => 'exists:student_classes,id',
		]);

        if ($request->has('firstname'))
            $user->firstname = $request->get('firstname');
        if ($request->has('lastname'))
            $user->lastname = $request->get('lastname');
		if ($request->has('email'))
			$user->email = $request->get('email');
        if ($request->has('password'))
            $user->password = bcrypt($request->get('password'));
		if ($request->has('group'))
			$user->group_id = $request->get('group');
		if ($request->has('student_class'))
			$user->class_id = $request->get('student_class');
		$user->save();

		return ($user);
    }

    /**
     * @api {get} /users/:id Display user
	 * @apiName show
	 * @apiGroup Users
	 *
     * @apiDescription Display the specified resource.
	 *
	 * @apiParam {Number} id	The ID of the user to display
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$user = User::with('group')
					->with('studentClass')
					->with('taughtSubjects')
					->with('marks.exam.lesson.subject')
					->with('criteriaAverages.criterion')
					->with('criteriaSums.criterion')
					->findOrFail($id);

		$this->authorize('show', $user);

        return $user;
    }

	/**
     * @api {get} /users/profile Display logged-in user
	 * @apiName profile
	 * @apiGroup Users
	 *
     * @apiDescription Display the profile of the logged-in user.
	 *
     * @return \Illuminate\Http\Response
     */
	public function profile()
	{
		$user = Auth::user();

		$user->load('group');
		$user->load('studentClass');
		$user->load('taughtSubjects');
		$user->load('marks.exam.lesson.subject');
		$user->load('criteriaAverages.criterion');
		$user->load('criteriaSums.criterion');

		$prevMonday = date("Y-m-d", strtotime("last week monday"));
		$sunday = date("Y-m-d 23:59:59", strtotime("sunday"));

		$user->recentLessons = Lesson::where('student_class_id', $user->class_id)
							   ->where('start', '>=', $prevMonday)
							   ->where('end', '<=', $sunday)
							   ->with('subject')
							   ->get();

		$user->homeworks = Lesson::where('student_class_id', $user->class_id)
								 ->where('start', '>=', $prevMonday)
								 ->where('end', '<=', $sunday)
								 ->with('homeworks')
								 ->with('subject.teacher')
								 ->whereHas('homeworks')
								 ->get();

		return $user;
	}

    /**
	 * @api {delete} /users/:id Delete user
	 * @apiName destroy
	 * @apiGroup Users
	 *
     * @apiDescription Remove the specified resource from storage.
	 *
	 * @apiParam {Number} id	The ID of the user to delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

		$this->authorize('destroy', $user);

		$user->delete();
    }

    /**
	 * @api {put} /users/change-password Change password
	 * @apiName changePassword
	 * @apiGroup Users
	 *
     * @apiDescription Change the password of the authenticated user.
	 *
	 * @apiParam {String} password		The current password of the user
	 * @apiParam {String} new_password	The new password of the user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'password' => 'required',
            'new_password' => 'required|different:password'
        ]);

        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return ($user);
    }
}
