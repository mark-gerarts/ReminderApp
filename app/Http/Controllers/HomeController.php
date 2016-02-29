<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Mail;
use Twilio;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('home.index');
    }

    public function pricing()
    {
        // This works
        //Twilio::message('+32494896349', 'Hello, world');

        return view('home.pricing');
    }

    public function faq()
    {
        return view('home.faq');
    }
}
