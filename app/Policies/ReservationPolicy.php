<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Planning\Reservation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('reservations.index');
	}

    /**
     * Determine whether the user can view the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Reservation  $reservation
     * @return mixed
     */
    public function show(User $user, Reservation $reservation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('reservations.show');
    }

    /**
     * Determine whether the user can create reservations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('reservations.store');
    }

    /**
     * Determine whether the user can update the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Reservation  $reservation
     * @return mixed
     */
    public function update(User $user, Reservation $reservation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('reservations.update');
    }

    /**
     * Determine whether the user can delete the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Planning\Reservation  $reservation
     * @return mixed
     */
    public function destroy(User $user, Reservation $reservation)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('reservations.destroy');
    }
}
