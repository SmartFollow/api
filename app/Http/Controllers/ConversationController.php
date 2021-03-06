<?php
namespace App\Http\Controllers;

use App\Models\Communication\Conversation;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * @api {get} /conversations List conversations
	 * @apiName index
	 * @apiGroup Conversations
	 *
     * @apiDescription Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('index', Conversation::class);

		return Conversation::whereHas('participants', function($q) {
			$q->where('users.id', Auth::id());
		})->with('participants')->get();
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('store', Conversation::class);

		$users = User::get();

		return [
			'users' => $users,
		];
	}

    /**
     * @api {post} /conversations Store new conversation
	 * @apiName store
	 * @apiGroup Conversations
	 *
     * @apiDescription Store a newly created resource in storage.
	 *
	 * @apiParam {String}	subject			Subject
	 * @apiParam {Number[]}	participants	An array of the ID of the participants
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('store', Conversation::class);

	     $this->validate($request, [
            'subject' => 'required',
			'participants.*' => 'exists:users,id'
        ]);

        $conversation = new Conversation();
        $conversation->creator_id = Auth::id();
        $conversation->subject = $request->get('subject');
        $conversation->save();

		$conversation->participants()->sync($request->get('participants'));
		if (!$conversation->participants->contains(Auth::id()))
			$conversation->participants()->attach(Auth::id());

		$conversation->load('participants');

        return $conversation;
    }

    /**
     * @api {get} /conversations/:id Show conversation
	 * @apiName show
	 * @apiGroup Conversations
	 *
     * @apiDescription Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conversation = Conversation::with('messages')
									->with('participants')
									->findOrFail($id);

	    $this->authorize('show', $conversation);

	    $conversation->load('messages.creator');

        return $conversation;
    }

    /**
     * @api {put} /conversations/:id Update conversation
	 * @apiName update
	 * @apiGroup Conversations
	 *
     * @apiDescription Update the specified resource in storage.
	 *
	 * @apiParam {String}	subject		Subject
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);

	    $this->authorize('update', $conversation);

	    $this->validate($request, [
            'subject' => 'required',
        ]);

        if ($request->has('subject'))
            $conversation->conversation_id = $request->get('subject');

        $conversation->save();

        return ($conversation);
    }

    /**
     * @api {delete} /conversations/:id Delete existing conversation
	 * @apiName delete
	 * @apiGroup Conversations
	 *
     * @apiDescription Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conversation = Conversation::findOrFail($id);

	    $this->authorize('destroy', $conversation);

	    $conversation->delete();
    }
}