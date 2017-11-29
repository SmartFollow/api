<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Pedagogy\Lesson;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

	public function index(User $user)
	{
		$rules = $user->group->accessRules->keyBy('name');

		return $rules->has('lessons.index') || $rules->has('lessons.self.index');
	}

    /**
     * Determine whether the user can view the lesson.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Lesson  $lesson
     * @return mixed
     */
    public function show(User $user, Lesson $lesson)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('lessons.show');
    }

    /**
     * Determine whether the user can create lessons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('lessons.store');
    }

    /**
     * Determine whether the user can update the lesson.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Lesson  $lesson
     * @return mixed
     */
    public function update(User $user, Lesson $lesson)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('lessons.update');
    }

    /**
     * Determine whether the user can delete the lesson.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Lesson  $lesson
     * @return mixed
     */
    public function destroy(User $user, Lesson $lesson)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('lessons.destroy');
    }
}
