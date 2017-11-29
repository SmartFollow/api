<?php

namespace App\Policies;

use App\User;
use App\Models\Pedagogy\Evaluations\Evaluation;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluationPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('evaluations.index');
	}

    /**
     * Determine whether the user can view the evaluation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Evaluation  $evaluation
     * @return mixed
     */
    public function show(User $user, Evaluation $evaluation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('evaluations.show');
    }

    /**
     * Determine whether the user can create evaluations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('evaluations.store');
    }

    /**
     * Determine whether the user can update the evaluation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Evaluation  $evaluation
     * @return mixed
     */
    public function update(User $user, Evaluation $evaluation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('evaluations.update');
    }

    /**
     * Determine whether the user can delete the evaluation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Evaluations\Evaluation  $evaluation
     * @return mixed
     */
    public function destroy(User $user, Evaluation $evaluation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('evaluations.destroy');
    }
}
