<?php

namespace App\Policies;

use App\User;
use App\Models\Pedagogy\Alert;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlertPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('alerts.index');
    }

}
