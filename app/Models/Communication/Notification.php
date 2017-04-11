<?php

namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function users()
	{
		return $this->belongsToMany('App\Models\Users\User')->withPivot('read_at');
	}
}
