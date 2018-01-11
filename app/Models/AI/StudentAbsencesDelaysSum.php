<?php

namespace App\Models\AI;

use Illuminate\Database\Eloquent\Model;

class StudentAbsencesDelaysSum extends Model
{
    protected $table = 'ai_student_absence_delay';
	protected $fillable = ['user_id', 'absences', 'delays', 'week_start', 'week_end', 'week', 'year'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
