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
		return Conversation::whereHas('participants', function($q) {
			$q->where('users.id', Auth::id());
		})->with('participants')->get();
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
			'participants.*' => 'exists:users,id'
        ]);

        $conversation = new Conversation();
        $conversation->creator_id = Auth::id();
        $conversation->subject = $request->get('subject');
        $conversation->save();

		$conversation->participants()->sync($request->get('participants'));
		$conversation->participants()->attach(Auth::id());

		$conversation->load('participants');

        return $conversation;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conversation = Conversation::with('messages')
									->with('participants')
									->findOrFail($id);

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