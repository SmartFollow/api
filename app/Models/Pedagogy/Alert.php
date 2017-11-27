<?php

namespace App\Models\Pedagogy;

use App\Models\Pedagogy\Evaluations\Criterion;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    public function student()
    {
    	return $this->belongsTo(User::class, 'student_id');
    }

    public function criterion()
    {
    	return $this->belongsTo(Criterion::class);
    }
}
