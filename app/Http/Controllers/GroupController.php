<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Users\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return Group::get();
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
			'name' => 'required|unique:groups',
			'description' => 'required',
		]);

		$group = new Group();
		$group->name = $request->get('name');
		$group->description = $request->get('description');
		$group->save();

		return ($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Group::findOrFail($id);
    }

	/**
	 * Display the group's access rules.
	 * @param type $id
	 * @return type
	 */
	public function showAccessRules($id)
    {
        return Group::with('accessRules')->findOrFail($id)->access_rules;
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
		$this->validate($request, [
			'name' => 'unique:groups,id',
			'description' => '',
		]);

        $group = Group::findOrFail($id);
		if ($request->has('name'))
			$group->name = $request->get('name');
		if ($request->has('description'))
			$group->description = $request->get('description');
		$group->save();

		return ($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);

		if (!$group->deletable)
			abort(403, trans('group.not_deletable'));
		else
			$group->delete();
    }
}
