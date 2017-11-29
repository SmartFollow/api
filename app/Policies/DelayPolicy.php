<?php

namespace App\Policies;

use App\User;
use App\Models\Pedagogy\Evaluations\Delay;
use Illuminate\Auth\Access\HandlesAuthorization;

class DelayPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create delays.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('delays.store');
    }

    /**
     * Determine whether the user can delete the delay.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Delay  $delay
     * @return mixed
     */
    public function destroy(User $user, Delay $delay)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('delays.destroy');
    }
}
