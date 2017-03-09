<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Users\User;
use App\Models\Users\Group;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->authorize('index', User::class);

		return User::get();
    }

	public function profileAccessRules()
	{
		$group = Group::with('accessRules')->findOrFail(Auth::user()->group_id);

		return $group->accessRules;
	}

    /**
     * Store a newly created resource in storage.
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
			'studentClass' => 'exists:student_classes,id',
		]);

		$user = new User();
        $user->firstname = $request->get('firstname');
        $user->lastname = $request->get('lastname');
		$user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
		if ($request->has('group'))
			$user->group_id = $request->get('group');
		if ($request->has('studentClass'))
			$user->class_id = $request->get('studentClass');
		$user->save();

		return ($user);
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
        $user = User::findOrFail($id);

		$this->authorize('update', $user);

		$this->validate($request, [
            'firstname' => '',
            'lastname' => '',
            'email' => 'email|unique:users,email,' . $id,
            'password' => '',
			'group' => 'exists:groups,id',
			'studentClass' => 'exists:student_classes,id',
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
		if ($request->has('studentClass'))
			$user->class_id = $request->get('studentClass');
		$user->save();

		return ($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$user = User::with('group')->findOrFail($id);

		$this->authorize('show', $user);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
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
     * Change user password.
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
