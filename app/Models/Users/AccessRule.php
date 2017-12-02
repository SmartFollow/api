<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class AccessRule extends Model
{
	public $timestamps = false;
	protected $hidden = ['pivot'];

	public function groups()
	{
		return $this->belongsToMany('App\Models\Users\Group');
	}

}
