<?php

namespace App\Models\Pedagogy;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function subject()
	{
		return $this->belongsTo('App\Models\Pedagogy\Subject');
	}

}
