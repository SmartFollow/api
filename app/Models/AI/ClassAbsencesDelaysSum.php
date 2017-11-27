<?php

namespace App\Models\AI;

use Illuminate\Database\Eloquent\Model;

class ClassAbsencesDelaysSum extends Model
{
    protected $table = 'ai_class_absence_delay';
	protected $fillable = ['student_class_id', 'absences', 'delays', 'week_start', 'week_end', 'week', 'year'];
}
