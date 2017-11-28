<?php

namespace App\Models\AI;

use App\Models\Pedagogy\Evaluations\Criterion;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class GivenCriterionAverage extends Model
{
    protected $table = 'ai_given_criterion_averages';
    protected $fillable = ['teacher_id', 'criterion_id', 'average', 'week_start', 'week_end', 'week', 'year'];

    public function teacher()
    {
    	return $this->belongsTo(User::class, 'teacher_id');
    }

    public function criterion()
    {
    	return $this->belongsTo(Criterion::class);
    }
}
