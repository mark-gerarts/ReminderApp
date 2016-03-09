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
        //
    }

    /**
     * Show the website homepage.
     *
     * @return Response
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * Show the pricing page.
     *
     * @return Response
     */
    public function pricing()
    {
        return view('home.pricing');
    }

    /**
     * Show the FAQ page - soon to be contact page.
     *
     * @return Response
     */
    public function faq()
    {
        return view('home.faq');
    }
}
