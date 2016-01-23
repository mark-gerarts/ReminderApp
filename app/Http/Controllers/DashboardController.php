<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Contact;
use Illuminate\Http\Request;
use Auth;
use Validate;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard.home');
    }
    
    public function contacts()
    {
        return view('dashboard.contacts');
    }
    
    public function history()
    {
        return view('dashboard.history');
    }
}
