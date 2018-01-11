<?php

namespace App\Models\Pedagogy;

use App\Models\Pedagogy\Evaluations\Criterion;
use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    public function criterion()
    {
    	return $this->belongsTo(Criterion::class);
    }
}
