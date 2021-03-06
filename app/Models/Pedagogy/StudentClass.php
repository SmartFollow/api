<?php

namespace App\Models\Pedagogy;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
	public function level()
	{
		return $this->belongsTo('App\Models\Pedagogy\Level');
	}

	public function students()
	{
		return $this->hasMany('App\Models\Users\User', 'class_id', 'id');
	}

	public function subjects()
	{
		return $this->belongsToMany('App\Models\Pedagogy\Subject');
	}

	public function mainTeacher()
	{
		return $this->belongsTo(User::class, 'main_teacher_id');
	}
}
