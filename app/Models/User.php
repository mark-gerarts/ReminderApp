<?php

namespace App\Models;

use App\Models\Contact; //Not working
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reminders()
    {
        return $this->hasMany('Reminder');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact'); //Use not working here ..?
    }
}
