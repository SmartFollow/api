<?php
namespace App\Http\Controllers;

use App\Models\Communication\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Only get conversations where user is participating

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
            'subject' => 'required',
        ]);

        $conversation = new Conversation();
        $conversation->creator_id = Auth::id();
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
        $conversation = Conversation::with('messages')->findOrFail($id);

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
            'subject' => 'required',
        ]);

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
        $conversation = Conversation::findOrFail($id);

        $conversation->delete();
    }
}