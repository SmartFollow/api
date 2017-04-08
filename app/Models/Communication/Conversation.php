<?php

namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //

    /*protected $fillable = [
    'creator_id', 'subject',,
    ];
*/

    public function conversations()
    {
        return this;
        //return $this->hasMany('App\Models\Communication\Message');
    }
}
