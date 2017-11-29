<?php

namespace App\Policies;

use App\User;
use App\Models\Pedagogy\Exams\Exam;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the exam.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Exams\Exam  $exam
     * @return mixed
     */
    public function show(User $user, Exam $exam)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('exams.show');
    }

    /**
     * Determine whether the user can create exams.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('exams.store');
    }

    /**
     * Determine whether the user can update the exam.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Exams\Exam  $exam
     * @return mixed
     */
    public function update(User $user, Exam $exam)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('exams.update');
    }

    /**
     * Determine whether the user can delete the exam.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Exams\Exam  $exam
     * @return mixed
     */
    public function destroy(User $user, Exam $exam)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('exams.destroy');
    }
}
