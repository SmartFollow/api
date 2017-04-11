<?php
namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public function messages()
    {
        return $this->hasMany('App\Models\Communication\Message');
    }

	public function participants()
	{
		return $this->belongsToMany('App\Models\Users\User', 'conversation_user', 'conversation_id', 'user_id');
	}

	public function creator()
	{
		return $this->belongsTo('App\Models\Users\User', 'creator_id');
	}
}
