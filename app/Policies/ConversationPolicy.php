<?php

namespace App\Policies;

use App\User;
use App\Models\Communication\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('conversations.index');
	}

    /**
     * Determine whether the user can view the conversation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Communication\Conversation  $conversation
     * @return mixed
     */
    public function show(User $user, Conversation $conversation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    $conversation->load('participants');

	    return $rules->has('conversations.show') && $conversation->participants->contains($user->id);
    }

    /**
     * Determine whether the user can create conversations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('conversations.store');
    }

    /**
     * Determine whether the user can update the conversation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Communication\Conversation  $conversation
     * @return mixed
     */
    public function update(User $user, Conversation $conversation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    $conversation->load('creator');

	    return $rules->has('conversations.update') && $conversation->creator->id == $user->id;
    }

    /**
     * Determine whether the user can delete the conversation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Communication\Conversation  $conversation
     * @return mixed
     */
    public function destroy(User $user, Conversation $conversation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    $conversation->load('creator');

	    return $rules->has('conversations.destroy') && $conversation->creator->id == $user->id;
    }
}
