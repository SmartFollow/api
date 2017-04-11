<?php
namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function conversation()
    {
        return $this->belongsTo('App\Models\Communication\Conversation');
    }

	public function creator()
	{
		return $this->belongsTo('App\Models\Users\User', 'creator_id');
	}
}
