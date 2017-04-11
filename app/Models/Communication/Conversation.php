<?php
namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public function messages()
    {
        return $this->hasMany('App\Models\Communication\Message');
    }
}
