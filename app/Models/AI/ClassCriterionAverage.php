<?php

namespace App\Models\AI;

use App\Models\Pedagogy\Evaluations\Criterion;
use App\Models\Pedagogy\StudentClass;
use Illuminate\Database\Eloquent\Model;

class ClassCriterionAverage extends Model
{
	protected $table = 'ai_class_criterion_sums';
	protected $fillable = ['student_class_id', 'criterion_id', 'average', 'week_start', 'week_end', 'week', 'year'];

	public function studentClass()
	{
		return $this->belongsTo(StudentClass::class);
	}

	public function criterion()
	{
		return $this->belongsTo(Criterion::class);
	}
}
