<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
	protected $appends = ['has_lesson'];

    public function lessons()
	{
		return $this->hasMany('App\Models\Pedagogy\Lesson');
	}

	public function room()
	{
		return $this->belongsTo('App\Models\Planning\Room');
	}

	public function getHasLessonAttribute()
	{
		$hasLesson = null;

		if (!array_key_exists('lessons', $this->relations)) {
			$this->load('lessons');
			$hasLesson = count($this->lessons) > 0;
			unset($this->lessons);
		}
		else
			$hasLesson = count($this->lessons) > 0;

		return $hasLesson;
	}
}
