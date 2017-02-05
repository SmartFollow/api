<?php

namespace App\Models\Pedagogy\Evaluations;

use Illuminate\Database\Eloquent\Model;

use App\Models\Pedagogy\Lesson;

class Evaluation extends Model
{
    public function lesson()
	{
		return $this->belongsTo(Lesson::class);
	}
}
