<?php

namespace App\Models\Pedagogy\Exams;

use Illuminate\Database\Eloquent\Model;

use App\Models\Pedagogy\Lesson;

class Exam extends Model
{
    public function lesson()
	{
		return $this->belongsTo(Lesson::class);
	}
}
