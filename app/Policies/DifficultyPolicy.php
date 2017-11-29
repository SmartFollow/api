<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\AI\Difficulty;
use Illuminate\Auth\Access\HandlesAuthorization;

class DifficultyPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('difficulties.index') || $rules->has('difficulties.self.index');
    }

}
