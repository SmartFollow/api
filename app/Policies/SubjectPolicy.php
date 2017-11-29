<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Pedagogy\Subject;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('subjects.');
	}

    /**
     * Determine whether the user can view the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Subject  $subject
     * @return mixed
     */
    public function show(User $user, Subject $subject)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('subjects.');
    }

    /**
     * Determine whether the user can create subjects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('subjects.');
    }

    /**
     * Determine whether the user can update the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Subject  $subject
     * @return mixed
     */
    public function update(User $user, Subject $subject)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('subjects.');
    }

    /**
     * Determine whether the user can delete the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Subject  $subject
     * @return mixed
     */
    public function destroy(User $user, Subject $subject)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('subjects.');
    }
}
