<?php

namespace App\Models\Pedagogy;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    public function lesson()
	{
		return $this->belongsTo('App\Models\Pedagogy\Lesson');
	}

}
