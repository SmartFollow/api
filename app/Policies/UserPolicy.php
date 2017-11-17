<?php

namespace App\Policies;

use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $userAuthed
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $userAuthed)
    {
        $rules = $userAuthed->group->accessRules->keyBy('name');

		return $rules->has('users.index');
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $userAuthed
     * @param  \App\User  $user
     * @return mixed
     */
    public function show(User $userAuthed, User $user)
    {
        $rules = $userAuthed->group->accessRules->keyBy('name');

		return	$rules->has('users.show')
				|| ($rules->has('users.profile') && $userAuthed->id == $user->id);
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $userAuthed
     * @return mixed
     */
    public function create(User $userAuthed)
    {
        $rules = $userAuthed->group->accessRules->keyBy('name');

		return $rules->has('users.create') || $rules->has('users.store');
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $userAuthed
     * @return mixed
     */
    public function store(User $userAuthed)
    {
        $rules = $userAuthed->group->accessRules->keyBy('name');

		return $rules->has('users.create') || $rules->has('users.store');
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $userAuthed
     * @param  \App\User  $user
     * @return mixed
     */
    public function edit(User $userAuthed, User $user)
    {
        $rules = $userAuthed->group->accessRules->keyBy('name');

		return $rules->has('users.edit');
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $userAuthed
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $userAuthed, User $user)
    {
        $rules = $userAuthed->group->accessRules->keyBy('name');

		return $rules->has('users.update');
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $userAuthed
     * @param  \App\User  $user
     * @return mixed
     */
    public function destroy(User $userAuthed, User $user)
    {
        $rules = $userAuthed->group->accessRules->keyBy('name');

		return $rules->has('users.destroy');
    }
}
