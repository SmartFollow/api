<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Pedagogy\StudentClass;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentClassPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('student-classes.index');
	}

    /**
     * Determine whether the user can view the studentClass.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\StudentClass  $studentClass
     * @return mixed
     */
    public function show(User $user, StudentClass $studentClass)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('student-classes.show');
    }

    /**
     * Determine whether the user can create studentClasses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('student-classes.store');
    }

    /**
     * Determine whether the user can update the studentClass.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\StudentClass  $studentClass
     * @return mixed
     */
    public function update(User $user, StudentClass $studentClass)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('student-classes.update');
    }

    /**
     * Determine whether the user can delete the studentClass.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\StudentClass  $studentClass
     * @return mixed
     */
    public function destroy(User $user, StudentClass $studentClass)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('student-classes.destroy');
    }
}
