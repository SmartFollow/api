<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Pedagogy\Graph;
use Illuminate\Auth\Access\HandlesAuthorization;

class GraphPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('graphs.index');
	}

    /**
     * Determine whether the user can view the graph.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Graph  $graph
     * @return mixed
     */
    public function show(User $user, Graph $graph)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('graphs.show');
    }

    /**
     * Determine whether the user can create graphs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('graphs.store');
    }

    /**
     * Determine whether the user can update the graph.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Graph  $graph
     * @return mixed
     */
    public function update(User $user, Graph $graph)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('graphs.update');
    }

    /**
     * Determine whether the user can delete the graph.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Graph  $graph
     * @return mixed
     */
    public function destroy(User $user, Graph $graph)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('graphs.destroy');
    }
}
