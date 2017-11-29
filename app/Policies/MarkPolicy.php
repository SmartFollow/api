<?php

namespace App\Policies;

use App\User;
use App\Models\Pedagogy\Exams\Mark;
use Illuminate\Auth\Access\HandlesAuthorization;

class MarkPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('marks.index');
	}

    /**
     * Determine whether the user can create marks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('marks.store');
    }

    /**
     * Determine whether the user can update the mark.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Exams\Mark  $mark
     * @return mixed
     */
    public function update(User $user, Mark $mark)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('marks.update');
    }

    /**
     * Determine whether the user can delete the mark.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Exams\Mark  $mark
     * @return mixed
     */
    public function destroy(User $user, Mark $mark)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('marks.destroy');
    }
}
