<?php

namespace App\Models\Pedagogy\Evaluations;

use Illuminate\Database\Eloquent\Model;

use App\Models\Pedagogy\Evaluations\Evaluation;
use App\Pivots\CriterionEvaluationPivot;

class Criterion extends Model
{
	public function newPivot(Model $parent, array $attributes, $table, $exists)
	{
		if ($parent instanceof Evaluation)
		{
			return new CriterionEvaluationPivot($parent, $attributes, $table, $exists);
		}

		return parent::newPivot($parent, $attributes, $table, $exists);
	}
}
