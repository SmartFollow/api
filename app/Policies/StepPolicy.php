<?php

namespace App\Policies;

use App\User;
use App\Models\Planning\Step;
use Illuminate\Auth\Access\HandlesAuthorization;

class StepPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create steps.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('steps.store');
    }

    /**
     * Determine whether the user can update the step.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Step  $step
     * @return mixed
     */
    public function update(User $user, Step $step)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('steps.update');
    }

    /**
     * Determine whether the user can delete the step.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Step  $step
     * @return mixed
     */
    public function destroy(User $user, Step $step)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('steps.destroy');
    }
}
