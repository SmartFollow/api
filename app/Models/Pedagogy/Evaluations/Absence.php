<?php

namespace App\Models\Pedagogy\Evaluations;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    public $timestamps = false;

    public function evaluation()
    {
    	return $this->belongsTo(Evaluation::class);
    }
}
