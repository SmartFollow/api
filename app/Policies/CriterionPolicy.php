<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Pedagogy\Evaluations\Criterion;
use Illuminate\Auth\Access\HandlesAuthorization;

class CriterionPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('criteria.index');
	}

    /**
     * Determine whether the user can view the criterion.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Criterion  $criterion
     * @return mixed
     */
    public function show(User $user, Criterion $criterion)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('criteria.show');
    }

    /**
     * Determine whether the user can create criteria.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('criteria.store');
    }

    /**
     * Determine whether the user can update the criterion.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Criterion  $criterion
     * @return mixed
     */
    public function update(User $user, Criterion $criterion)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('criteria.update');
    }

    /**
     * Determine whether the user can delete the criterion.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Criterion  $criterion
     * @return mixed
     */
    public function destroy(User $user, Criterion $criterion)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('criteria.destroy');
    }
}
