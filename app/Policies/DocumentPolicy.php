<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Pedagogy\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the document.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Document  $document
     * @return mixed
     */
    public function show(User $user, Document $document)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('documents.show');
    }

    /**
     * Determine whether the user can create documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('documents.store');
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Document  $document
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('documents.update');
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Pedagogy\Document  $document
     * @return mixed
     */
    public function destroy(User $user, Document $document)
    {
	    $rules = $user->group->accessRules->keyBy('name');

	    return $rules->has('documents.destroy');
    }
}
