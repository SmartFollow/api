<?php

namespace App\Policies;

use App\User;
use App\Models\Pedagogy\Homework;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeworkPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('homeworks.index');
	}

    /**
     * Determine whether the user can view the homework.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Homework  $homework
     * @return mixed
     */
    public function show(User $user, Homework $homework)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('homeworks.show');
    }

    /**
     * Determine whether the user can create homeworks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('homeworks.store');
    }

    /**
     * Determine whether the user can update the homework.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Homework  $homework
     * @return mixed
     */
    public function update(User $user, Homework $homework)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('homeworks.update');
    }

    /**
     * Determine whether the user can delete the homework.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Homework  $homework
     * @return mixed
     */
    public function destroy(User $user, Homework $homework)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('homeworks.destroy');
    }
}
