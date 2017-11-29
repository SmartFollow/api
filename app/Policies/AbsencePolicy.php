<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Pedagogy\Evaluations\Absence;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbsencePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('absences.index');
    }

    /**
     * Determine whether the user can create absences.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('absences.store');
    }

    /**
     * Determine whether the user can update the absence.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Absence  $absence
     * @return mixed
     */
    public function update(User $user, Absence $absence)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('absences.update');
    }

    /**
     * Determine whether the user can delete the absence.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Absence  $absence
     * @return mixed
     */
    public function destroy(User $user, Absence $absence)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('absences.destroy');
    }
}
