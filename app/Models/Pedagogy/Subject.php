<?php

namespace App\Models\Pedagogy;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function level()
	{
		return $this->belongsTo('App\Models\Pedagogy\Level');
	}

	public function teacher()
	{
		return $this->belongsTo('App\Models\Users\User', 'teacher_id', 'id');
	}

	public function studentClasses()
	{
		return $this->belongsToMany('App\Models\Pedagogy\StudentClass');
	}
}
