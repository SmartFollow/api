<?php
/**
 * Created by PhpStorm.
 * User: steev
 * Date: 06/01/2017
 * Time: 19:06
 */

namespace App\Http\Controllers;

use App\Models\Communication\Message;
use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends Controller
{
    /**
     * Getter
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Message::get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * creator id, conversation_id and content are all stored.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'creator_id' => 'required',
            'conversation_id' => 'required',
            'content' => 'required',
        ]);

        $message = new Message();
        $message->creator_id = $request->get('creator_id');
        $message->conversation_id = $request->get('conversation_id');
        $message->content = $request->get('content');
        $message->save();

        return ($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $message = Process::findOrFail($id);

        return $message;
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
        $message = Message::findOrFail($id);

        $this->validate($request, [
            'creator_id' => 'required',
            'conversation_id' => 'required',
            'content' => 'required',
        ]);

        $message = new Message();
        if ($request->has('creator_id'))
            $message->creator_id = $request->get('creator_id');
        if ($request->has('conversation_id'))
            $message->conversation_id = $request->get('conversation_id');
        if ($request->has('content'))
            $message->content = $request->get('content');
        $message->save();

        return ($message);
    }

    /**
     * Remove the specified resource (a process) from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $message = Message::findOrFail($id);
        $message->delete();
    }
}