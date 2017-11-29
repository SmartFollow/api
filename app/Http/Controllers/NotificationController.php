<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Communication\Notification;
use App\Models\Users\Group;
use App\Models\Pedagogy\StudentClass;

class NotificationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$this->authorize('index', Notification::class);

		$notifications = [];

		if (Auth::user()->group->accessRules->keyBy('name')->has('notifications.self.index'))
		{
			$notifications['self_notifications'] = Notification::with('transmitter')
				->whereHas('users', function ($q) use ($request) {
					$q->where('users.id', Auth::id());

					if ($request->has('type') && $request->get('type') == 'unread')
						$q->where('read_at', null);
				})->get();
		}
		if (Auth::user()->group->accessRules->keyBy('name')->has('notifications.index'))
		{
			$notifications['notifications'] = Notification::with('transmitter')
															   ->get();
		}

		return $notifications;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('store', Notification::class);

		return [
			'groups' => Group::get(),
			'studentClasses' => StudentClass::get(),
		];
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->authorize('store', Notification::class);

		$this->validate($request, [
			'resource_link' => '',
			'message' => 'required',
			'user' => 'required_without_all:users,group,student_class|exists:users,id',
			'users.*' => 'required_without_all:user,group,student_class|exists:users,id',
			'group' => 'required_without_all:user,users,student_class|exists:groups,id',
			'student_class' => 'required_without_all:user,users,group|exists:student_classes,id',
		]);

		$notification = new Notification();
		$notification->transmitter_id = Auth::id();
		$notification->resource_link = $request->get('resource_link');
		$notification->message = $request->get('message');
		$notification->save();

		if ($request->has('user')) {
			$notification->users()->attach($request->get('user'));
		}
		if ($request->has('users')) {
			$notification->users()->syncWithoutDetaching($request->get('users'));
		}
		if ($request->has('group')) {
			$group = Group::with('users')->findOrFail($request->get('group'));
			$notification->users()->syncWithoutDetaching($group->users);
		}
		if ($request->has('student_class')) {
			$studentClass = StudentClass::with('students')->findOrFail($request->get('student_class'));
			$notification->users()->syncWithoutDetaching($studentClass->students);
		}

		return $notification;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$notification = Notification::with('transmitter')
									->with('users')
									->findOrFail($id);

		$this->authorize('show', $notification);

		return $notification;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$notification = Notification::findOrFail($id);

		$this->authorize('update', $notification);

		return $notification;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$notification = Notification::findOrFail($id);

		$this->authorize('update', $notification);

		$this->validate($request, [
			'transmitter_id' => '',
			'resource_link' => '',
			'message' => '',
			'user' => 'required_without_all:users,group,student_class|exists:users,id',
			'users.*' => 'required_without_all:user,group,student_class|exists:users,id',
			'group' => 'required_without_all:user,users,student_class|exists:groups,id',
			'student_class' => 'required_without_all:user,users,group|exists:student_classes,id',
		]);

		if ($request->has('transmitter_id'))
			$notification->transmitter_id = Auth::id();
		if ($request->has('resource_link'))
			$notification->resource_link = $request->get('resource_link');
		if ($request->has('message'))
			$notification->message = $request->get('message');
		$notification->save();

		if ($request->has('user')) {
			$notification->users()->attach($request->get('user'));
		}
		if ($request->has('users')) {
			$notification->users()->syncWithoutDetaching($request->get('users'));
		}
		if ($request->has('group')) {
			$group = Group::with('users')->findOrFail($request->get('group'));
			$notification->users()->syncWithoutDetaching($group->users);
		}
		if ($request->has('student_class')) {
			$studentClass = StudentClass::with('students')->findOrFail($request->get('student_class'));
			$notification->users()->syncWithoutDetaching($studentClass->students);
		}

		return $notification;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$notification = Notification::findOrFail($id);

		$this->authorize('destroy', $notification);

		$notification->delete();
	}

	/**
	 * Mark the notification as read.
	 *
	 * @param  int $id
	 * @return void
	 */
	public function markAsRead($id)
	{
		$notification = Notification::findOrFail($id);

		$this->authorize('markAsRead', $notification);

		$notification->users()->updateExistingPivot(Auth::id(), ['read_at' => new \DateTime()]);
	}

}
