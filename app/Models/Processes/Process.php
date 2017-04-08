<?php

namespace App\Models\Processes;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
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

    public function steps()
    {
        return $this->hasMany('App\Models\Processes\Step');
    }

}
