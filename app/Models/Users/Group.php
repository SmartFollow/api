<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

	public function accessRules()
	{
		return $this->belongsToMany('App\Models\Users\AccessRule');
	}

}
