<?php
/*
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function reminders()
    {
        return $this->hasMany('Reminder');
    }
    public $timestamps = false;  
}
*/
namespace App\Models;

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
}
