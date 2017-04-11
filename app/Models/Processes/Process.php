<?php

namespace App\Models\Processes;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    public function steps()
    {
        return $this->hasMany('App\Models\Processes\Step');
    }
}
