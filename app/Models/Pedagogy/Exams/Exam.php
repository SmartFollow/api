<?php

namespace App\Models\Pedagogy\Exams;

use App\Models\Pedagogy\Document;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pedagogy\Lesson;

class Exam extends Model
{
    public function lesson()
	{
		return $this->belongsTo(Lesson::class);
	}

	public function marks()
	{
		return $this->hasMany(Mark::class);
	}

	public function document()
	{
		return $this->belongsTo(Document::class);
	}
}
