<?php
/**
 * Created by PhpStorm.
 * User: steev
 * Date: 06/01/2017
 * Time: 21:30
 */

namespace App\Http\Controllers;

use App\Models\Communication\Conversation;
use Illuminate\Http\Request;

use App\Http\Requests;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Conversation::get();
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
            'creator_id' => 'required',
            'subject' => 'required',
        ]);

        $conversation = new Conversation();
        $conversation->creator_id = $request->get('creator_id');
        $conversation->subject = $request->get('subject');
        $conversation->save();

        return ($conversation);
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
        $conversation = Process::findOrFail($id);

        return $conversation;
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
        $conversation = Conversation::findOrFail($id);

        $this->validate($request, [
            'creator_id' => 'required',
            'subject' => 'required',
        ]);

        $conversation = new Conversation();
        if ($request->has('creator_id'))
            $conversation->creator_id = $request->get('creator_id');
        if ($request->has('subject'))
            $conversation->conversation_id = $request->get('subject');

        $conversation->save();

        return ($conversation);
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
        $conversation = Conversation::findOrFail($id);
        $conversation->delete();
    }
}