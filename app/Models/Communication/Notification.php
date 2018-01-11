<?php

namespace App\Models\Communication;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $appends = ['users_count'];

    public function users()
	{
		return $this->belongsToMany('App\Models\Users\User')->withPivot('read_at');
	}

	public function transmitter()
	{
		return $this->belongsTo(User::class, 'transmitter_id');
	}

	public function getUsersCountAttribute()
	{
		if (!array_key_exists('users', $this->relations)) {
			$this->load('users');
			$count = count($this->users);
			unset($this->users);

			return $count;
		}
		else
			return count($this->users);
	}
}
