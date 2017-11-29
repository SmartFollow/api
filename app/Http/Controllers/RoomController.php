<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Planning\Room;

class RoomController extends Controller
{
    /**
     * @api {get} /rooms List rooms
	 * @apiName index
	 * @apiGroup Rooms
	 *
     * @apiDescription Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->authorize('index', Room::class);

	    $room = Room::get();

        return $room;
    }

    /**
     * @api {get} /rooms/create Create room form
	 * @apiName create
	 * @apiGroup Rooms
	 *
     * @apiDescription Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->authorize('store', Room::class);


    }

    /**
     * @api {post} /rooms Store new room
	 * @apiName store
	 * @apiGroup Rooms
	 *
     * @apiDescription Store a newly created resource in storage.
	 *
	 * @apiParam {String} identifier	An identifier for the room (e.g. room name)
	 * @apiParam {Number} [seats]		The number of seats in the room
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('store', Room::class);

	    $this->validate($request, [
            'identifier' => 'required',
            'seats' => 'numeric|min:1',
        ]);

        $room = new Room();
        $room->identifier = $request->get('identifier');
        $room->seats = $request->get('seats');
        $room->save();

        return $room;
    }

    /**
     * @api {get} /rooms/:id Display room
	 * @apiName show
	 * @apiGroup Rooms
	 *
     * @apiDescription Display the specified resource.
	 *
	 * @apiParam {Number} id	The ID of the room
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);

	    $this->authorize('show', $room);

	    return $room;
    }

    /**
     * @api {get} /rooms/:id/edit Edit room form
	 * @apiName edit
	 * @apiGroup Rooms
	 *
     * @apiDescription Show the form for editing the specified resource.
	 *
	 * @apiParam {Number} id	The ID of the room
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $room = Room::findOrFail($id);

	    $this->authorize('update', $room);

	    return $room;
    }

    /**
     * @api {put} /rooms/:id Update room
	 * @apiName update
	 * @apiGroup Rooms
	 *
     * @apiDescription Update the specified resource in storage.
	 *
	 * @apiParam {Number} id	The ID of the room
	 *
	 * @apiParam {String} [identifier]	An identifier for the room (e.g. room name)
	 * @apiParam {Number} [seats]		The number of seats in the room
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

	    $this->authorize('update', $room);

	    $this->validate($request, [
            'identifier' => '',
            'seats' => 'numeric|min:1',
        ]);

        if ($request->has('identifier'))
            $room->identifier = $request->get('identifier');
        if ($request->has('seats'))
            $room->seats = $request->get('seats');
        $room->save();

        return $room;
    }

    /**
     * @api {delete} /rooms/:id Delete room
	 * @apiName destroy
	 * @apiGroup Rooms
	 *
     * @apiDescription Remove the specified resource from storage.
	 *
	 * @apiParam {Number} id	The ID of the room
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

	    $this->authorize('destroy', $room);

	    $room->delete();
    }
}
