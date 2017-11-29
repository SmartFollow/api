<?php

namespace App\Policies;

use App\User;
use App\Models\Planning\Room;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('rooms.index');
	}

    /**
     * Determine whether the user can view the room.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Room  $room
     * @return mixed
     */
    public function show(User $user, Room $room)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('rooms.show');
    }

    /**
     * Determine whether the user can create rooms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('rooms.store');
    }

    /**
     * Determine whether the user can update the room.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Room  $room
     * @return mixed
     */
    public function update(User $user, Room $room)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('rooms.update');
    }

    /**
     * Determine whether the user can delete the room.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Room  $room
     * @return mixed
     */
    public function destroy(User $user, Room $room)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('rooms.destroy');
    }
}
