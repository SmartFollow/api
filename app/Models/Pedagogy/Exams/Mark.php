<?php

namespace App\Models\Pedagogy\Exams;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    public function exam()
	{
		return $this->belongsTo(Exam::class);
	}
}
