<?php

namespace App\Models\Processes;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function users()
    {
    	return $this->belongsToMany(User::class)
		            ->withPivot(['step_id'])
		            ->withTimestamps();
    }
}
