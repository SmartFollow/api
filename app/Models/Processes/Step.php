<?php
namespace App\Models\Processes;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    public function process()
    {
        return $this->belongsTo('App\Models\Processes\Process');
    }
}
