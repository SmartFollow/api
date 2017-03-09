<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CriterionEvaluationPivot extends Pivot
{
	public function getValueAttribute($value)
	{
		return $value != null ? json_decode($value) : null;
	}
}
