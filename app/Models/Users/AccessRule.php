<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class AccessRule extends Model
{

	protected $hidden = ['pivot'];

	public function groups()
	{
		return $this->belongsToMany('App\Models\Users\Group');
	}

}
