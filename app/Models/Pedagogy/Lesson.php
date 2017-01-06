<?php

namespace App\Models\Pedagogy;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function subject()
	{
		return $this->belongsTo('App\Models\Pedagogy\Subject');
	}

	public function reservation()
	{
		return $this->belongsTo('App\Models\Planning\Reservation');
	}

	public function documents()
	{
		return $this->hasMany('App\Models\Pedagogy\Document');
	}

	public function homeworks()
	{
		return $this->hasMany('App\Models\Pedagogy\Homework');
	}

	public function exam()
	{
		return $this->hasOne('App\Models\Pedagogy\Exams\Exam');
	}

	public function studentClass()
	{
		return $this->belongsTo('App\Models\Pedagogy\StudentClass');
	}

}
