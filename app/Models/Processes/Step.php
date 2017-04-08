<?php

namespace App\Models\Processes;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name', 'description',
    ];*/

    public function process()
    {
        return $this->belongsTo('App\Models\Processes\Process');
    }
}
