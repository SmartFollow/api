<?php

namespace App\Models\AI;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Difficulty extends Model
{
	protected $fillable = ['student_id', 'week', 'year'];

    public function student()
    {
    	return $this->belongsTo(User::class, 'student_id');
    }

    public function assignedTeacher()
    {
    	return $this->belongsTo(User::class, 'assigned_teacher_id');
    }
}
