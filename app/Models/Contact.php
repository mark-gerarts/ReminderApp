<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('User');
    }
}
