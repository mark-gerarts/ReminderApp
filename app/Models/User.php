<?php

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