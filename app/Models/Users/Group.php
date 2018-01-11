<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $casts = [
		'deletable' => 'boolean',
		'editable' => 'boolean',
	];

	public function accessRules()
	{
		return $this->belongsToMany('App\Models\Users\AccessRule');
	}

	public function users()
	{
		return $this->hasMany('App\Models\Users\User');
	}

}
