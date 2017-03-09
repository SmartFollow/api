<?php

namespace App\Models\Pedagogy;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public function subjects()
	{
		return $this->hasMany('App\Models\Pedagogy\Subject');
	}

	public function studentClasses()
	{
		return $this->hasMany('App\Models\Pedagogy\StudentClass');
	}
}
