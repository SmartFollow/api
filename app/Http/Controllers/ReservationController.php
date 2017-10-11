<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Planning\Reservation;
use App\Models\Planning\Room;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::with('room')->get();

		return $reservations;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::get();
		
		return [
			'rooms' => $rooms,
		];
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
			'room_id' => 'required|exists:rooms,id',
			'time_start' => 'required|date_format:H:i',
			'time_end' => 'required|date_format:H:i',
			'date_start' => 'required|date_format:Y-m-d',
			'date_end' => 'required|date_format:Y-m-d',
			'day' => 'required|in:MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY,SATURDAY,SUNDAY',
		]);

		$conflict = Reservation::where('room_id', $request->get('room_id'))
							   ->where('day', $request->get('day'))
							   ->where('date_start', '<=', $request->get('date_start'))
							   ->where('date_end', '>=', $request->get('date_end'))
							   ->where('time_start', '<=', $request->get('time_start'))
							   ->where('time_end', '>=', $request->get('time_end'))
							   ->count();

		if ($conflict != 0)
			return [
				"error" => trans('reservations.conflict')
			];

		$reservation = new Reservation();
		$reservation->room_id = $request->get('room_id');
		$reservation->time_start = $request->get('time_start');
		$reservation->time_end = $request->get('time_end');
		$reservation->date_start = $request->get('date_start');
		$reservation->date_end = $request->get('date_end');
		$reservation->day = $request->get('day');
		$reservation->save();

		return $reservation;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);

		return $reservation;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rooms = Room::get();
		
		return [
			'rooms' => $rooms,
		];
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
			'room_id' => 'exists:rooms,id',
			'time_start' => 'date_format:H:i',
			'time_end' => 'date_format:H:i',
			'date_start' => 'date_format:Y-m-d',
			'date_end' => 'date_format:Y-m-d',
			'day' => 'in:MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY,SATURDAY,SUNDAY',
		]);
		
		$conflict = Reservation::where('room_id', $request->get('room_id'))
							   ->where('day', $request->get('day'))
							   ->where('date_start', '<=', $request->get('date_start'))
							   ->where('date_end', '>=', $request->get('date_end'))
							   ->where('time_start', '<=', $request->get('time_start'))
							   ->where('time_end', '>=', $request->get('time_end'))
							   ->where('id', '!=', $id)
							   ->count();
		
		if ($conflict != 0)
			return [
				"error" => trans('reservations.conflict')
			];

		$reservation = Reservation::findOrFail($id);
		if ($request->has('room_id'))
			$reservation->room_id = $request->get('room_id');
		if ($request->has('time_start'))
			$reservation->time_start = $request->get('time_start');
		if ($request->has('time_end'))
			$reservation->time_end = $request->get('time_end');
		if ($request->has('date_start'))
			$reservation->date_start = $request->get('date_start');
		if ($request->has('date_end'))
			$reservation->date_end = $request->get('date_end');
		if ($request->has('day'))
			$reservation->day = $request->get('day');
		$reservation->save();

		return $reservation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
		
		$reservation->delete();
    }
}
