<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_order extends Model
{
    use SoftDeletes;
    
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
