<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Users\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return User::get();
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
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
		]);

		$user = new User();
        $user->firstname = $request->get('firstname');
        $user->lastname = $request->get('lastname');
		$user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
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

		$this->validate($request, [
            'firstname' => '',
            'lastname' => '',
            'email' => 'email|unique:users,email,' . $id,
            'password' => '',
		]);

        if ($request->has('firstname'))
            $user->firstname = $request->get('firstname');
        if ($request->has('lastname'))
            $user->lastname = $request->get('lastname');
		if ($request->has('email'))
			$user->email = $request->get('email');
        if ($request->has('password'))
            $user->password = bcrypt($request->get('password'));
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
        return User::findOrFail($id);
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

		$user->delete();
    }
}
