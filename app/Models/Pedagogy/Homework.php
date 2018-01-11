<?php

namespace App\Models\Pedagogy;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
	protected $table = 'homeworks';

    public function lesson()
	{
		return $this->belongsTo('App\Models\Pedagogy\Lesson');
	}

	public function document()
	{
		return $this->belongsTo('App\Models\Pedagogy\Document');
	}
}
