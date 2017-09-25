<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Users\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list of all groups.
     *
     * @param  App\User  $user
     * @param  App\Group  $group
     * @return mixed
     */
    public function index(User $user)
    {
        $rules = $user->group->accessRules->keyBy('name');

		return $rules->has('groups.index');
    }

    /**
     * Determine whether the user can view the group.
     *
     * @param  App\User  $user
     * @param  App\Group  $group
     * @return mixed
     */
    public function show(User $user, Group $group)
    {
        $rules = $user->group->accessRules->keyBy('name');

		return	$rules->has('groups.show')
				|| ($rules->has('groups.self.show') && $group->id == $user->group->id);
    }

    /**
     * Determine whether the user can view the group.
     *
     * @param  App\User  $user
     * @param  App\Group  $group
     * @return mixed
     */
    public function accessRules(User $user, Group $group)
    {
        $rules = $user->group->accessRules->keyBy('name');

		return	$rules->has('groups.show.access-rules')
				|| ($group->id == $user->group->id); // If it's the user's group
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $rules = $user->group->accessRules->keyBy('name');

		return $rules->has('groups.create');
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        $rules = $user->group->accessRules->keyBy('name');

		return $rules->has('groups.store');
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param  App\User  $user
     * @param  App\Group  $group
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        $rules = $user->group->accessRules->keyBy('name');

		return $rules->has('groups.update') && $group->editable;
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param  App\User  $user
     * @param  App\Group  $group
     * @return mixed
     */
    public function destroy(User $user, Group $group)
    {
        $rules = $user->group->accessRules->keyBy('name');

		return $rules->has('groups.destroy') && $group->deletable;
    }
}
