<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Communication\Notification;
use App\Models\Users\User;
use DateTime;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notif = Notification::get();

        return $notif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $notif = new Notification();
        $notif->transmitter_id = Auth::user()->id;
        $notif->resource_link = $request->get('resource_link');
        $notif->message = $request->get('message');
        $notif->save();

        $notif->users()->attach($request->get('user'));

        return $notif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notif = Notification::findOrFail($id);

        return $notif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $notif = Notification::findOrFail($id);

        $this->validate($request, [
            'transmitter_id' => '',
            'resource_link' => '',
            'message' => '',
            'user' => 'exists:users,id',
        ]);

        if ($request->has('transmitter_id'))
            $notif->transmitter_id = Auth::user()->id;
        if ($request->has('resource_link'))
            $notif->resource_link = $request->get('resource_link');
        if ($request->has('message'))
            $notif->message = $request->get('message');
        $notif->save();

        if ($request->has('user'))
        {
            $notif->users()->attach($request->get('user'));
        }

        return $notif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notif = Notification::findOrFail($id);

        $notif->delete();
    }


    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function ReadAt($id)
    {
        $notif = Notification::findOrFail($id);

        $date = new \DateTime();
        $usableDate = $date->format('Y-m-d H:i:s');

        foreach ($notif->users as $notifs)
        {
            $read = $notifs->pivot_read_at;
            if (is_null($read)) {
                $read = $usableDate;
                //$read->save();
            }
            var_dump($read);
        }
        return $read;
    }

}
