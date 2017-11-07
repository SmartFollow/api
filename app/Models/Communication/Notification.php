<?php

namespace App\Models\Communication;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function users()
	{
		return $this->belongsToMany('App\Models\Users\User')->withPivot('read_at');
	}

	public function transmitter()
	{
		return $this->belongsTo(User::class, 'transmitter_id');
	}
}
