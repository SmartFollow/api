<?php

namespace App\Policies;

use App\User;
use App\Models\Pedagogy\Level;
use Illuminate\Auth\Access\HandlesAuthorization;

class LevelPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('levels.index');
	}

    /**
     * Determine whether the user can view the level.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Level  $level
     * @return mixed
     */
    public function show(User $user, Level $level)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('levels.show');
    }

    /**
     * Determine whether the user can create levels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('levels.store');
    }

    /**
     * Determine whether the user can update the level.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Level  $level
     * @return mixed
     */
    public function update(User $user, Level $level)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('levels.update');
    }

    /**
     * Determine whether the user can delete the level.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Level  $level
     * @return mixed
     */
    public function destroy(User $user, Level $level)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('levels.destroy');
    }

	public function addStudentClasses(User $user, Level $level)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('levels.add-student-classes');
	}

	public function listStudentClasses(User $user, Level $level)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('levels.list-student-classes');
	}

	public function listSubjects(User $user, Level $level)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('levels.list-subjects');
	}
}
