<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
//use Illuminate\Foundation\Validation\ValidatesRequests;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TestController extends BaseController
{
    public function index()
    {
        return 'index';
    }
    
    public function showProfile($id)
    {
        $user = "Test User: id: " . $id;
        return $user;
    }
}