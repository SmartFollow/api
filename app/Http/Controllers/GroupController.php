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
		$this->authorize('index', Group::class);

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
		$this->authorize('create', Group::class);

		$this->validate($request, [
			'name' => 'required|unique:groups',
			'description' => 'required',
			'access_rules.*' => 'exists:access_rules,id'
		]);

		$group = new Group();
		$group->name = $request->get('name');
		$group->description = $request->get('description');
		$group->save();

		$group->accessRules()->sync($request->get('access_rules'));

		return $group;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$group = Group::findOrFail($id);

		$this->authorize('show', $group);

        return $group;
    }

	/**
	 * Display the group's access rules.
	 * @param type $id
	 * @return type
	 */
	public function showAccessRules($id)
    {
		$group = Group::with('accessRules')->findOrFail($id);

		$this->authorize('accessRules', $group);

        return $group->accessRules->pluck('route');
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
		$group = Group::findOrFail($id);

		$this->authorize('update', $group);

		$this->validate($request, [
			'name' => 'unique:groups',
			'description' => '',
			'access_rules.*' => 'exists:access_rules,id'
		]);

		if (!$group->editable)
			abort(403, trans('group.not_editable'));

		if ($request->has('name'))
			$group->name = $request->get('name');
		if ($request->has('description'))
			$group->description = $request->get('description');
		$group->save();

		if ($request->has('access_rules'))
		{
			$group->accessRules()->sync($request->get('access_rules'));
		}

		return $group;
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

		$this->authorize('destroy', $group);

		if (!$group->deletable)
			abort(403, trans('group.not_deletable'));
		else
			$group->delete();
    }
}
