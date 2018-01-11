<?php

namespace App\Models\AI;

use App\Models\Pedagogy\Evaluations\Criterion;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class StudentCriterionSum extends Model
{
	protected $table = 'ai_student_criterion_sums';
	protected $fillable = ['user_id', 'criterion_id', 'sum', 'week_start', 'week_end', 'week', 'year'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function criterion()
	{
		return $this->belongsTo(Criterion::class);
	}
}
