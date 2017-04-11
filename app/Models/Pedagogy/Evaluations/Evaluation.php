<?php

namespace App\Models\Pedagogy\Evaluations;

use Illuminate\Database\Eloquent\Model;

use App\Models\Pedagogy\Lesson;
use App\Models\Pedagogy\Evaluations\Criterion;
use App\Models\Users\User;
use App\Pivots\CriterionEvaluationPivot;

class Evaluation extends Model
{
    public function lesson()
	{
		return $this->belongsTo(Lesson::class);
	}

	public function criteria()
	{
		return $this->belongsToMany(Criterion::class, 'criterion_evaluation', 'evaluation_id', 'criterion_id')
					->withPivot('value')
					->withTimestamps();
	}

	public function student()
	{
		return $this->belongsTo(User::class, 'student_id');
	}

	public function newPivot(Model $parent, array $attributes, $table, $exists)
	{
		if ($parent instanceof Criterion)
		{
			return new CriterionEvaluationPivot($parent, $attributes, $table, $exists);
		}

		return parent::newPivot($parent, $attributes, $table, $exists);
	}
}
