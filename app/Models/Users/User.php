<?php

namespace App\Models\Users;

use App\Models\AI\StudentCriterionAverage;
use App\Models\Pedagogy\Evaluations\Evaluation;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Pedagogy\Exams\Mark;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function group()
	{
		return $this->belongsTo('App\Models\Users\Group');
	}

    public function notifications()
    {
        return $this->belongsToMany('App\Models\Communication\Notification');
    }

	public function conversations()
	{
		return $this->belongsToMany('App\Models\Communication\Conversation', 'conversation_user', 'user_id', 'conversation_id');
	}

	public function studentClass()
	{
		return $this->belongsTo('App\Models\Pedagogy\StudentClass', 'class_id');
	}

	public function taughtSubjects()
	{
		return $this->hasMany('App\Models\Pedagogy\Subject', 'teacher_id', 'id');
	}

	public function marks()
	{
		return $this->hasMany(Mark::class, 'student_id');
	}

	public function evaluations()
	{
		return $this->hasMany(Evaluation::class, 'student_id');
	}

	/*
	 * AI data relationships
	 */
	public function criteriaAverages()
	{
		return $this->hasMany(StudentCriterionAverage::class)
					->orderBy('year', 'ASC')
					->orderBy('week', 'ASC');
	}

}
