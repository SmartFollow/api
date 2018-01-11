<?php

namespace App\Models\Pedagogy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{

    public function lesson()
	{
		return $this->belongsTo('App\Models\Pedagogy\Lesson');
	}

	public function getPathAttribute($path)
	{
		return Storage::url($path);
	}

}
