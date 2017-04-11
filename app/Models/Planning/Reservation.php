<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function lessons()
	{
		return $this->hasMany('App\Models\Pedagogy\Lesson');
	}

	public function room()
	{
		return $this->belongsTo('App\Models\Planning\Room');
	}
}
