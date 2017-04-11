<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Communication\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$notification = Notification::whereHas('users', function ($q) {
			$q->where('users.id', Auth::id());
		})->get();

        return $notification;
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
            'transmitter_id' => '',
            'resource_link' => '',
            'message' => 'required',
            'user' => 'exists:users,id',
        ]);

        $notification = new Notification();
        $notification->transmitter_id = Auth::id();
        $notification->resource_link = $request->get('resource_link');
        $notification->message = $request->get('message');
        $notification->save();

        $notification->users()->attach($request->get('user'));

        return $notification;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);

        return $notification;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = Notification::findOrFail($id);

        return $notification;
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
        $notification = Notification::findOrFail($id);

        $this->validate($request, [
            'transmitter_id' => '',
            'resource_link' => '',
            'message' => '',
            'user' => 'exists:users,id',
        ]);

        if ($request->has('transmitter_id'))
            $notification->transmitter_id = Auth::id();
        if ($request->has('resource_link'))
            $notification->resource_link = $request->get('resource_link');
        if ($request->has('message'))
            $notification->message = $request->get('message');
        $notification->save();

        if ($request->has('user'))
        {
            $notification->users()->attach($request->get('user'));
        }

        return $notification;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->delete();
    }

    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function readAt($id)
    {
        $notification = Notification::findOrFail($id);

		$notification->users()->updateExistingPivot(Auth::id(), ['read_at' => new \DateTime()]);
    }

}
