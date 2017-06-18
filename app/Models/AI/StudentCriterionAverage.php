<?php

namespace App\Models\AI;

use App\Models\Pedagogy\Evaluations\Criterion;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class StudentCriterionAverage extends Model
{
    protected $table = 'ai_student_criterion_averages';
    protected $fillable = ['user_id', 'criterion_id', 'average', 'week_start', 'week_end', 'week', 'year'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function criterion()
    {
    	return $this->belongsTo(Criterion::class);
    }
}
