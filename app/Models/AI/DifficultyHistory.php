<?php

namespace App\Models\AI;

use Illuminate\Database\Eloquent\Model;

class DifficultyHistory extends Model
{
    protected $table = 'difficulty_history';

	protected $fillable = ['student_id', 'week', 'year'];
}
