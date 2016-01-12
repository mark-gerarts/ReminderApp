<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reminder;
use Illuminate\Routing\Controller as BaseController;


class HomeController extends BaseController
{
    public function __construct()
    {
        
    }
    
    public function Index()
    {
        return view('home.index');
    }
    
    public function Pricing()
    {
        $data['users'] = User::all();
        $data['reminders'] = Reminder::all();
        
        return view('home.pricing', $data);
    }
}