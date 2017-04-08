<?php
/**
 * Created by PhpStorm.
 * User: steev
 * Date: 15/02/2017
 * Time: 14:40
 */

namespace App\Models\Users;


class GetPassword
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * Informations required for account creation
     *
     * @var array
     */
    /*protected $fillable = [
        'firstname', 'lastname', 'birthday', 'status', 'email', 'password',
    ];*/

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}