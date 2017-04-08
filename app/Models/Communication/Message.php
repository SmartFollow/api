<?php

namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

    /*protected $fillable = [
        'creator_id', 'conversation_id', 'content',
        ];
    */

    public function messages()
    {
        return this;
        //return $this->hasMany('App\Models\Communication\Message');
    }
}
