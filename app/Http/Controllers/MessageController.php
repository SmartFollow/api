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
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class MessageController extends Controller
{
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
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required',
        ]);

		// Check if user is participant to conversation

        $message = new Message();
        $message->creator_id = Auth::id();
        $message->conversation_id = $request->get('conversation_id');
        $message->content = $request->get('content');
        $message->save();

        return ($message);
    }
}
