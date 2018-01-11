<?php

namespace App\Policies;

use App\Models\Processes\Process;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProcessPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('processes.index');
	}

    /**
     * Determine whether the user can view the process.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Process  $process
     * @return mixed
     */
    public function show(User $user, Process $process)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('processes.show');
    }

    /**
     * Determine whether the user can create processes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('processes.store');
    }

    /**
     * Determine whether the user can update the process.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Process  $process
     * @return mixed
     */
    public function update(User $user, Process $process)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('processes.update');
    }

    /**
     * Determine whether the user can delete the process.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Process  $process
     * @return mixed
     */
    public function destroy(User $user, Process $process)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('processes.destroy');
    }
}
