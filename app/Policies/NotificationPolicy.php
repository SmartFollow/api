<?php

namespace App\Policies;

use App\User;
use App\Models\Communication\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('notifications.index') || $rules->has('notifications.self.index');
	}

    /**
     * Determine whether the user can view the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Communication\Notification  $notification
     * @return mixed
     */
    public function show(User $user, Notification $notification)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('notifications.show');
    }

    /**
     * Determine whether the user can create notifications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('notifications.store');
    }

    /**
     * Determine whether the user can update the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Communication\Notification  $notification
     * @return mixed
     */
    public function update(User $user, Notification $notification)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('notifications.update');
    }

    /**
     * Determine whether the user can delete the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Communication\Notification  $notification
     * @return mixed
     */
    public function destroy(User $user, Notification $notification)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('notifications.destroy');
    }

	public function markAsRead(User $user, Notification $notification)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('notifications.mark-as-read');
	}
}
