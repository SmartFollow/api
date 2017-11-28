<?php

namespace App\Models\AI;

use Illuminate\Database\Eloquent\Model;

class GivenAbsencesDelaysSum extends Model
{
    protected $table = 'ai_given_absence_delay';
	protected $fillable = ['teacher_id', 'absences', 'delays', 'week_start', 'week_end', 'week', 'year'];

	public function teacher()
	{
		return $this->belongsTo(User::class, 'teacher_id');
	}
}
